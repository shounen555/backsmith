<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SchoolYearsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index()
{
    // Get the current date
    $currentDate = Carbon::now();

    // Get the current year
    $currentYear = $currentDate->year;

    // Retrieve school years where the "from" or "to" dates are in the current year
    $schoolYears = SchoolYear::whereYear('from', '<=', $currentYear )->orderByDesc('from')
        ->get();

    // Add the "is_current" flag to each school year
    $schoolYears = $schoolYears->map(function ($schoolYear) use ($currentDate) {
        // Check if the current date is between the "from" and "to" dates of the school year
        $isCurrent = $currentDate->between($schoolYear->from, $schoolYear->to);

        // Add the "is_current" flag to the school year object
        $schoolYear->is_current = $isCurrent;

        return $schoolYear;
    });

    return response()->json($schoolYears); // Return the modified school years as a JSON response
}


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }
}
