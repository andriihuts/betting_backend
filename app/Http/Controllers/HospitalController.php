<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    /**
     * Display a listing of the hospitals.
     */
    public function index()
    {
        $hospitals = Hospital::all();
        return response()->json(['hospitals' => $hospitals], 200);
    }

    /**
     * Store a newly created hospital in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hospital_name' => 'required|string|max:255',
        ]);

        $hospital = Hospital::create($validated);

        return response()->json([
            'message' => 'Hospital added successfully.',
            'hospital' => $hospital,
        ], 201);
    }

    /**
     * Display the specified hospital.
     */
    public function show(Hospital $hospital)
    {
        return response()->json(['hospital' => $hospital], 200);
    }

    /**
     * Update the specified hospital in storage.
     */
    public function update(Request $request, Hospital $hospital)
    {
        $validated = $request->validate([
            'hospital_name' => 'required|string|max:255',
        ]);

        $hospital->update($validated);

        return response()->json([
            'message' => 'Hospital updated successfully.',
            'hospital' => $hospital,
        ], 200);
    }

    /**
     * Remove the specified hospital from storage.
     */
    public function destroy(Hospital $hospital)
    {
        // Check if any logbook entries are using this hospital
        if ($hospital->logbooks()->exists()) {
            return response()->json([
                'message' => 'Cannot delete. This hospital is used in one or more logbook entries.',
            ], 400); // 400 Bad Request or 409 Conflict
        }
        
        $hospital->delete();

        return response()->json([
            'message' => 'Hospital deleted successfully.'
        ], 200);
    }
}
