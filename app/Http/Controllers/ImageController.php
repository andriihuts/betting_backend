<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /**
     * Display a listing of the images.
     */
    public function index()
    {
        $images = Image::all();
        return response()->json(['images' => $images], 200);
    }

    /**
     * Store a newly created image in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'logbook_id' => 'required|integer|exists:logbooks,id',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        if (empty($validated)) {
            return response()->json([
                'message' => 'No data provided to update.',
            ], 422);
        }

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $extension = $file->getClientOriginalExtension();
            $filename = uniqid('attachment_');
            $filename = str_replace(' ', '', $filename) . '.' . $extension;
        
            $filePath = $file->storeAs('logbook_attachments', $filename, 'public');

            // Create a related image record
            Image::create([
                'logbook_id' => $validated['logbook_id'],
                'image_url' => $filePath,
            ]);
        }

        // Return the file path or success response
        return response()->json([
            'status' => true,
            'message' => 'File uploaded successfully!'
        ]);
    }

    /**
     * Display the specified image.
     */
    public function show(Image $image)
    {
        return response()->json(['image' => $image], 200);
    }

    /**
     * Update the specified image in storage.
     */
    public function update(Request $request, Image $image)
    {
        // Validate the new uploaded file
        $validated = $request->validate([
            'attachment' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Delete the old file from storage if it exists
        if ($image->image_url && Storage::disk('public')->exists($image->image_url)) {
            Storage::disk('public')->delete($image->image_url);
        }

        // Store the new file
        $file = $request->file('attachment');
        $extension = $file->getClientOriginalExtension();
        $filename = uniqid('attachment_') . '.' . $extension;
        $filename = str_replace(' ', '', $filename);

        $filePath = $file->storeAs('logbook_attachments', $filename, 'public');

        // Update image record
        $image->update([
            'image_url' => $filePath,
        ]);

        return response()->json([
            'message' => 'Image updated successfully.',
            'image' => $image,
        ], 200);
    }

    /**
     * Remove the specified image from storage.
     */
    public function destroy(Image $image)
    {
        Storage::disk('public')->delete($image->image_url);
        $image->delete();

        return response()->json([
            'message' => 'Image deleted successfully.'
        ], 200);
    }
}
