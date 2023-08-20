<?php

namespace App\Http\Controllers;

use App\Models\Retard;
use Illuminate\Http\Request;

class RetardsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'date'          => 'required|date',
            'time'          => 'required|date_format:H:i',
            'is_justified'  => 'required|boolean',
            'justification' => 'nullable|string',
            'student_id'    => 'required|integer|exists:students,id',
        ]);

        // Create a new Tutor instance with the validated tutor data
        $retard = new Retard($validatedData);

        // Save the student to the database
        $retard->save();
        // Return a JSON response indicating success
        return response()->json(['retard' => $retard], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'date'          => 'required|date',
            'time'          => 'required|date_format:H:i',
            'is_justified'  => 'required|boolean',
            'justification' => 'nullable|string',
            'student_id'    => 'required|integer|exists:students,id',
        ]);

        $retard = Retard::find($id);
        // Update the retard model with the validated data
        $retard->update($validatedData);
        // Save the updated retard to the database
        $retard->save();

        // Return a JSON response indicating success
        return response()->json(['retard' => $retard], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $retard = Retard::find($id);

        // Delete the retard
        $retard->delete();

        // Return a response indicating success
        return response()->json(['message' => 'retard deleted successfully']);
    }
}