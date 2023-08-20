<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Tutor;
use Illuminate\Http\Request;

class TutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Get tutors of a specific student.
     *
     * @param  int  $studentId
     * @return \Illuminate\Http\Response
     */
    public function getStudentTutors($studentId)
    {
        // Find the student by ID
        $student = Student::find($studentId);

        // Retrieve the tutors for the student
        $tutors = $student->tutors;

        return response()->json($tutors);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'full_name'    => 'required|string',
            'cin'          => 'required|string',
            'profession'   => 'nullable|string',
            'tel_domicile' => 'nullable|string',
            'tel_bureau'   => 'nullable|string',
            'gsm'          => 'nullable|string',
            'observation'  => 'required|string',
            'student_id'   => 'required|integer|exists:students,id',
        ]);





        // Create a new Tutor instance with the validated tutor data
        $tutor = new Tutor($validatedData);

        // Save the student to the database
        $tutor->save();
        // Return a JSON response indicating success
        return response()->json(['tutor' => $tutor], 201);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the tutor by ID
        $tutor = Tutor::find($id);

        // Delete the tutor
        $tutor->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Tutor deleted successfully']);
    }
}