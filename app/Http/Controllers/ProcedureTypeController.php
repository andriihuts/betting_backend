<?php

namespace App\Http\Controllers;

use App\Models\ProcedureType;
use Illuminate\Http\Request;

class ProcedureTypeController extends Controller
{
    /**
     * Display a listing of procedure types.
     */
    public function index()
    {
        $procedureTypes = ProcedureType::all();
        return response()->json(['procedure_types' => $procedureTypes], 200);
    }

    /**
     * Store a newly created procedure type in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'procedure_type' => 'required|string|max:255',
        ]);

        $procedureType = ProcedureType::create($validated);

        return response()->json([
            'message' => 'Procedure type added successfully.',
            'procedure_type' => $procedureType,
        ], 201);
    }

    /**
     * Display the specified procedure type.
     */
    public function show(ProcedureType $procedureType)
    {
        return response()->json(['procedure_type' => $procedureType], 200);
    }

    /**
     * Update the specified procedure type in storage.
     */
    public function update(Request $request, ProcedureType $procedureType)
    {
        $validated = $request->validate([
            'procedure_type' => 'required|string|max:255',
        ]);

        $procedureType->update($validated);

        return response()->json([
            'message' => 'Procedure type updated successfully.',
            'procedure_type' => $procedureType,
        ], 200);
    }

    /**
     * Remove the specified procedure type from storage.
     */
    public function destroy(ProcedureType $procedureType)
    {
        // Check if any logbook entries are using this procedure type
        if ($procedureType->logbooks()->exists()) {
            return response()->json([
                'message' => 'Cannot delete. This procedure type is used in one or more logbook entries.',
            ], 400); // 400 Bad Request or 409 Conflict
        }

        $procedureType->delete();

        return response()->json([
            'message' => 'Procedure type deleted successfully.',
        ], 200);
    }
}
