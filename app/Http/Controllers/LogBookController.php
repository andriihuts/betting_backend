<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Image;
use App\Models\Logbook;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class LogBookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::with(['hospital', 'procedure_type'])->get();
        return response()->json(['log_books' => $logbooks], 200);
    }

    public function store(Request $request)
    {
        // Step 1: Validate request data
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'mrn' => 'nullable|string|max:255',
            'dob' => 'nullable|string|max:255',
            'procedure_date' => 'required|date',
            'role' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'procedure_type_id' => 'required|integer|exists:procedure_types,id',
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'attachment' => 'nullable|array',
            'attachment.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Step 2: Create the logbook record
        $logBook = LogBook::create($validated);

        // Step 3: Handle multiple file uploads if present
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                if ($file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = uniqid('attachment_') . '.' . $extension;
                    $filename = str_replace(' ', '', $filename);

                    // Save the file in the public disk
                    $filePath = $file->storeAs('logbook_attachments', $filename, 'public');

                    // Create a related image record
                    Image::create([
                        'logbook_id' => $logBook->id,
                        'image_url' => $filePath,
                    ]);
                }
            }
        }

        return response()->json([
            'message' => 'Logbook entry created successfully.',
            'log_book' => $logBook->load('images')->load('hospital')->load('procedure_type'),
        ], 201);
    }

    public function show(Logbook $logbook)
    {
        $logbook->load(['hospital', 'procedure_type']);
        return response()->json(['log_book' => $logbook], 200);
    }

    public function update(Request $request, LogBook $logbook)
    {
        // Step 1: Validate input
        $validated = $request->validate([
            'patient_name' => 'sometimes|required|string|max:255',
            'mrn' => 'nullable|string|max:255',
            'dob' => 'nullable|string|max:255',
            'procedure_date' => 'sometimes|required|date',
            'role' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string',
            'procedure_type_id' => 'sometimes|required|integer|exists:procedure_types,id',
            'hospital_id' => 'sometimes|required|integer|exists:hospitals,id',
            'attachment' => 'nullable|array',
            'attachment.*' => 'file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Step 2: Handle new file uploads (append to existing images)
        if ($request->hasFile('attachment')) {
            // If you want to delete all old images and replace with new
            $logbook->images()->each(function ($image) {
                Storage::disk('public')->delete($image->image_url);
                $image->delete();
            });

            foreach ($request->file('attachment') as $file) {
                if ($file->isValid()) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = uniqid('attachment_') . '.' . $extension;
                    $filename = str_replace(' ', '', $filename);

                    $filePath = $file->storeAs('logbook_attachments', $filename, 'public');

                    // Store new image in DB
                    Image::create([
                        'logbook_id' => $logbook->id,
                        'image_url' => $filePath,
                    ]);
                }
            }
        }

        // Step 3: Prevent empty update
        if (empty($validated)) {
            return response()->json([
                'message' => 'No data provided to update.',
            ], 422);
        }

        // Step 4: Update fields
        if (!empty($validated)) {
            $logbook->update($validated);
        }

        return response()->json([
            'message' => 'Logbook entry updated successfully.',
            'log_book' => $logbook->load('images')->load('hospital')->load('procedure_type'),
        ]);
    }


    public function destroy(Logbook $logbook)
    {
        // Delete file if exists
        $logbook->images()->each(function ($image) {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();
        });

        $logbook->delete();

        return response()->json([
            'message' => 'Log book entry deleted successfully.',
        ], 200);
    }

    public function generateReport(Request $request)
    {
        $request->validate([
            'time_range' => 'required|string',
            'procedure_type_id' => 'nullable|integer',
        ]);

        // Time filtering
        $now = Carbon::now();

        switch ($request->time_range) {
            case 'last_30_days':
                $startDate = $now->copy()->subDays(30);
                break;
            case 'last_6_months':
                $startDate = $now->copy()->subMonths(6);
                break;
            case 'last_year':
                $startDate = $now->copy()->subYear();
                break;
            case 'all':
                $startDate = Logbook::min('procedure_date');
                if ($startDate) {
                    $startDate = Carbon::parse($startDate);
                }
                break;
            default:
                return response()->json(['error' => 'Invalid time range'], 422);
        }

        $logbooks = $startDate != null
            ? Logbook::with(['hospital', 'procedure_type'])
                ->where('procedure_date', '>=', $startDate->toDateString())
            : Logbook::with(['hospital', 'procedure_type']);

        if ($request->procedure_type_id && $request->procedure_type_id !== 0 && $request->procedure_type_id !== '') {
            $logbooks->where('procedure_type_id', $request->procedure_type_id);
        }

        $logbooks = $logbooks->get();

        // Delete existing PDF files in storage/app/public/reports
        $reportFiles = Storage::disk('public')->files('reports');
        foreach ($reportFiles as $file) {
            Storage::disk('public')->delete($file);
        }

        // Generate PDF
        $pdf = Pdf::loadView('pdf.report', [
            'logbooks' => $logbooks,
            'from' => $startDate->format('M d, Y'),
            'to' => $now->format('M d, Y'),
        ]);

        // Store PDF
        $filename = 'logbook_report_' . now()->format('Ymd_His') . '.pdf';
        Storage::disk('public')->put("reports/{$filename}", $pdf->output());

        return response()->json([
            'message' => 'PDF generated successfully.',
            'file_path' => Storage::url("reports/{$filename}"),
        ]);
    }

}
