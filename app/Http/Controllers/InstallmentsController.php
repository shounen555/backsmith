<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Expense;
use App\Models\Inscription;
use App\Models\Installment;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Http\Request;

class InstallmentsController extends Controller
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
            'month'           => 'required',
            'payment_date'    => 'required|date',
            'montant'         => 'required|numeric',
            'is_cheque'       => 'required|boolean',
            'cheque_is_payed' => 'nullable|boolean',
            'cheque_number'   => 'nullable|string',
            'cheque_societe'  => 'nullable|string',
            'student_id'      => 'required|integer|exists:students,id',
        ]);

        // Create a new Tutor instance with the validated tutor data
        $installment           = new Installment($validatedData);
        $student               = Student::findOrFail($request->input('student_id'));
        $installment->class_id = $student->class_id;
        // Save the student to the database
        $installment->save();
        // Return a JSON response indicating success
        return response()->json(['installment' => $installment], 201);
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
            'month'           => 'required',
            'payment_date'    => 'required|date',
            'montant'         => 'required|numeric',
            'is_cheque'       => 'required|boolean',
            'cheque_is_payed' => 'nullable|boolean',
            'cheque_number'   => 'nullable|string',
            'cheque_societe'  => 'nullable|string',
            'student_id'      => 'required|integer|exists:students,id',
        ]);

        $installment = Installment::find($id);
        // Update the installmentmodel with the validated data
        $installment->update($validatedData);
        // Save the updated installment to the database
        $installment->save();

        // Return a JSON response indicating success
        return response()->json(['installment' => $installment], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the tutor by ID
        $installment = Installment::find($id);

        // Delete the installment
        $installment->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Installment deleted successfully']);
    }


    private function calculateTotalAmmountByMonth($installments)
    {
        $months = array_fill(0, 11, 0); // Initialize the array with 10 elements (September to June)

        foreach ($installments as $installment) {
            $monthIndex = (int) date('m', strtotime($installment->month)) - 9; // Get the month index (0 to 9 for September to June)

            if ($monthIndex < 0) {
                $monthIndex += 12; // Wrap around to treat February as 11th month, June as 5th, etc.
            }
            $months[$monthIndex] += $installment->montant;
        }

        return $months;
    }


    public function getHomeData($school_year_id)
    {
        $profit = 0;
        // Find the school year by ID
        $school_year = SchoolYear::find($school_year_id);

        // Retrieve the "from" and "to" dates of the school year
        $fromDate = $school_year->from;
        $toDate   = $school_year->to;

        // Retrieve the installments within the school year's date range
        $installments = Installment::whereBetween('month', [$fromDate, $toDate])->get();
        $expenses     = Expense::whereBetween('date', [$fromDate, $toDate])->sum('montant');
        $profit       = $profit + Installment::whereBetween('month', [$fromDate, $toDate])->sum('montant');
        // Group the installments by student, including the student's class information
        $installmentsByStudent = $installments->groupBy('class_id');

        $totalAmmountByClass = [];

        // Number of inner arrays
        $numberOfClasses = 3;

        // Number of elements in each inner array
        $numberOfElements = 11;

        // Loop to create and add inner arrays
        for ($i = 0; $i < $numberOfClasses; $i++) {
            // Create an array filled with 0, containing $numberOfElements elements
            $innerArray = array_fill(0, $numberOfElements, 0);

            // Add the inner array to the main array
            $totalAmmountByClass[] = $innerArray;
        }
        // Calculate the total amount by month for each student
        $totalAmmountByStudent = [];
        $gg                    = 0;
        foreach ($installmentsByStudent as $classId => $installments) {
            $totalAmmountByClass[$gg] = $this->calculateTotalAmmountByMonth($installments);
            $gg += 1;
        }



        // Get the inscriptions within the specified school year
        $inscriptions  = Inscription::where('school_year_id', $school_year_id)->get();
        $totalStudents = Student::where('school_year_id', $school_year_id)->count();

        // Group the inscriptions by their associated class
        $inscriptionsByClass = $inscriptions->groupBy('class_id');

        // Calculate the total amount for each class
        $totalAmountByClassd = [];

        foreach ($inscriptionsByClass as $classId => $classInscriptions) {
            $totalAmount                   = $classInscriptions->sum('montant');
            $class                         = Classe::find($classId);
            $totalAmountByClassd[$classId] = $totalAmount;
            $profit                        = $profit + $totalAmount;
        }


        // Group the inscriptions by student
        $inscriptionsByStudent = $inscriptions->groupBy('student_id');

        // Filter the students whose first inscription date is within the school year
        $studentsWithFirstInscriptionInYear = $inscriptionsByStudent->filter(function ($inscriptions) use ($school_year_id) {
            $firstInscription = $inscriptions->sortBy('payment_date')->first();
            return $firstInscription->school_year_id == $school_year_id;
        });

        // Count the number of students
        $numberOfStudentsWithInscriptionInYear = $studentsWithFirstInscriptionInYear->count();

        $classes              = Classe::all();
        $index                = 0;
        $totalStudentsByClass = array_fill(0, 3, 0);
        foreach ($classes as $classe) {
            $totalStudentsByClass[$index] = Student::where('class_id', $classe->id)->where('school_year_id', $school_year_id)->count();
            $index += 1;
        }


        return response()->json([
            'haha' => $installments,
            'total_by_classe' => $totalStudentsByClass,
            'total_students'  => $totalStudents,
            'count'           => $numberOfStudentsWithInscriptionInYear,
            'profit'          => $profit,
            'expenses'        => $expenses,
            'inscription'     => $totalAmountByClassd,
            'revenue'         => $totalAmmountByClass,
        ]);
    }
}