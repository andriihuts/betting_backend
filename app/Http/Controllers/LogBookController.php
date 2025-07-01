<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use Illuminate\Http\Request;
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
}
