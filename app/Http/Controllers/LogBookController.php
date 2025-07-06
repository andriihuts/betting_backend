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
        $logbooks = Logbook::with(['hospital', 'procedure_type', 'images'])->orderBy('procedure_date', 'desc')->get();
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
        ]);

        // Step 2: Create the logbook record
        $logBook = LogBook::create($validated);

        return response()->json([
            'message' => 'Logbook entry created successfully.',
            'log_book' => $logBook->load(['hospital', 'procedure_type', 'images'])
        ], 201);
    }

    public function show(Logbook $logbook)
    {
        $logbook->load(['hospital', 'procedure_type', 'images']);
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
        ]);

        // Step 2: Prevent empty update
        if (empty($validated)) {
            return response()->json([
                'message' => 'No data provided to update.',
            ], 422);
        }

        // Step 3: Update fields
        if (!empty($validated)) {
            $logbook->update($validated);
        }

        return response()->json([
            'message' => 'Logbook entry updated successfully.',
            'log_book' => $logbook->load(['hospital', 'procedure_type', 'images'])
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
        $validated = $request->validate([
            'since_date' => 'required|date',
            'procedure_type_id' => 'nullable|integer',
        ]);

        $startDate = Carbon::parse($validated['since_date']);
        $now = now();

        $logbooks = Logbook::with(['hospital', 'procedure_type'])
            ->whereDate('procedure_date', '>=', $startDate->toDateString());

        if (!empty($validated['procedure_type_id']) && (int)$validated['procedure_type_id'] !== 0) {
            $logbooks->where('procedure_type_id', $validated['procedure_type_id']);
        }

        $logbooks = $logbooks->orderBy('procedure_date', 'desc')->get();

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
