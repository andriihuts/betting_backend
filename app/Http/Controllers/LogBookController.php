<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
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
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'mrn' => 'required|string|max:255',
            'dob' => 'required|date',
            'procedure_date' => 'required|date',
            'role' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'procedure_type_id' => 'required|integer|exists:procedure_types,id',
            'hospital_id' => 'required|integer|exists:hospitals,id',
            'attachment' => 'nullable',
        ]);
        
        
        // Handle image file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('attachment_');
            $filename = str_replace(' ', '', $filename) . '.' . $extension;
        
            $filePath = $file->storeAs('logbook_attachments', $filename, 'public'); // stored in storage/app/public/logbook_attachments
            $validated['attachment_path'] = $filePath;
        }

        $logBook = LogBook::create($validated);

        return response()->json([
            'message' => 'Logbook entry created successfully.',
            'log_book' => $logBook,
        ], 201);
    }

    public function show(Logbook $logbook)
    {
        $logbook->load(['hospital', 'procedure_type']);
        return response()->json(['log_book' => $logbook], 200);
    }

    public function update(Request $request, LogBook $logbook)
    {
        $validated = $request->validate([
            'patient_name' => 'sometimes|required|string|max:255',
            'mrn' => 'sometimes|required|string|max:255',
            'dob' => 'sometimes|required|date',
            'procedure_date' => 'sometimes|required|date',
            'role' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string',
            'procedure_type_id' => 'sometimes|required|integer|exists:procedure_types,id',
            'hospital_id' => 'sometimes|required|integer|exists:hospitals,id',
            'attachment' => 'nullable',
        ]);

        // Handle image file upload
        if ($request->hasFile('attachment')) {

            // Delete old file if it exists
            if ($logbook->attachment_path && Storage::disk('public')->exists($logbook->attachment_path)) {
                Storage::disk('public')->delete($logbook->attachment_path);
            }

            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('attachment_');
            $filename = str_replace(' ', '', $filename) . '.' . $extension;
        
            $filePath = $file->storeAs('logbook_attachments', $filename, 'public'); // stored in storage/app/public/logbook_attachments
            $validated['attachment_path'] = $filePath;
        }

        $logbook->update($validated);

        return response()->json([
            'message' => 'Logbook entry updated successfully.',
            'log_book' => $logbook,
        ]);
    }


    public function destroy(Logbook $logbook)
    {
        // Delete file if exists
        if ($logbook->attachment_path) {
            Storage::disk('public')->delete($logbook->attachment_path);
        }

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
