<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the file
        $request->validate([
            'file' => 'required|file|mimes:jpg,png,pdf|max:2048', // Example: max 2MB
        ]);

        // Store the file
        $filePath = $request->file('file')->store('uploads', 'public');
        // $originalName = $request->file('file')->getClientOriginalName();
        // $filePath = $request->file('file')->storeAs('useful-website-icons', 'custom-name.jpg', 'public');
        $url = Storage::url($filePath);

        // Return the file path or success response
        return response()->json([
            'status' => true,
            'message' => 'File uploaded successfully!',
            'file_path' => $url,
        ]);
    }
}
