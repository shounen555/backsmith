<?php

namespace App\Http\Controllers;

use App\Models\Absence;
use Illuminate\Http\Request;

class AbsencesController extends Controller
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
            'from'          => 'required|date_format:H:i',
            'to'            => 'required|date_format:H:i|after:from',
            'is_justified'  => 'required|boolean',
            'justification' => 'nullable|string',
            'student_id'    => 'required|integer|exists:students,id',
        ]);

        // Create a new Tutor instance with the validated tutor data
        $absence= new Absence($validatedData);

        // Save the student to the database
        $absence->save();


  

        // Return a JSON response indicating success
        return response()->json(['absence' => $absence], 201);
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
            'from'          => 'required|date_format:H:i',
            'to'            => 'required|date_format:H:i|after:from',
            'is_justified'  => 'required|boolean',
            'justification' => 'nullable|string',
            'student_id'    => 'required|integer|exists:students,id',
        ]);

        $absence = Absence::find($id);
        // Update the absence model with the validated data
        $absence->update($validatedData);
        // Save the updated absence to the database
        $absence->save();

        // Return a JSON response indicating success
        return response()->json(['absence' => $absence], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $absence = Absence::find($id);

        // Delete the absence
        $absence->delete();

        // Return a response indicating success
        return response()->json(['message' => 'absence deleted successfully']);
    }
}
