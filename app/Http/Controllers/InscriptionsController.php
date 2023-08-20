<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Installment;
use App\Models\Student;
use Illuminate\Http\Request;

class InscriptionsController extends Controller
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
            'school_year_id'  => 'required',
            'payment_date'    => 'required|date',
            'montant'         => 'required|numeric',
            'is_cheque'       => 'required|boolean',
            'cheque_is_payed' => 'nullable|boolean',
            'cheque_number'   => 'nullable|string',
            'cheque_societe'  => 'nullable|string',
            'student_id'      => 'required|integer|exists:students,id',
        ]);

        // Create a new Tutor instance with the validated tutor data
        $inscription = new Inscription($validatedData);
        $student               = Student::findOrFail($request->input('student_id'));
        $inscription->class_id = $student->class_id;
        // Save the student to the database
        $inscription->save();


        $inscription->school_year = $inscription->schoolYear->name;
        unset($inscription->schoolYear);


        // Return a JSON response indicating success
        return response()->json(['inscription' => $inscription], 201);
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
        $validatedData = $request->validate([
            'school_year_id'  => 'required',
            'payment_date'    => 'required|date',
            'montant'         => 'required|numeric',
            'is_cheque'       => 'required|boolean',
            'cheque_is_payed' => 'nullable|boolean',
            'cheque_number'   => 'nullable|string',
            'cheque_societe'  => 'nullable|string',
            'student_id'      => 'required|integer|exists:students,id',
        ]);


        $inscription = Inscription::find($id);
        // Update the inscription model with the validated data
        $inscription->update($validatedData);
        // Save the updated inscriptionto the database
        $inscription->save();

        // Return a JSON response indicating success
        return response()->json(['inscription' => $inscription], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the tutor by ID
        $inscription = Inscription::find($id);

        // Delete the inscription
        $inscription->delete();

        // Return a response indicating success
        return response()->json(['message' => 'inscription deleted successfully']);
    }
}