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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // max 5MB
        ]);

        // Handle file upload if present
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('logbook_attachments', 'public');
            $validated['attachment_path'] = $path;
        }

        $logBook = LogBook::create($validated);

        return response()->json([
            'message' => 'Log book entry created successfully.',
            'log_book' => $logBook,
        ], 201);
    }

    public function show(Logbook $logBook)
    {
        return response()->json(['log_book' => $logBook], 200);
    }

    public function update(Request $request, Logbook $logBook)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // max 5MB
        ]);

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($logBook->attachment_path) {
                Storage::disk('public')->delete($logBook->attachment_path);
            }

            $path = $request->file('attachment')->store('logbook_attachments', 'public');
            $validated['attachment_path'] = $path;
        }

        $logBook->update($validated);

        return response()->json([
            'message' => 'Log book entry updated successfully.',
            'log_book' => $logBook,
        ], 200);
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

        $logbooks = $startDate != null ? Logbook::with(['hospital', 'procedure_type'])->where('procedure_date', '>=', $startDate->toDateString()) : Logbook::with(['hospital', 'procedure_type']);

        if ($request->procedure_type_id && $request->procedure_type_id !== 0 && $request->procedure_type_id !== '') {
            $logbooks->where('procedure_type_id', $request->procedure_type_id);
        }

        $logbooks = $logbooks->get();

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
