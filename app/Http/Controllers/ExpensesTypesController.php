<?php

namespace App\Http\Controllers;

use App\Models\ExpenseType;
use Illuminate\Http\Request;

class ExpensesTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses_types = ExpenseType::all();
        return response()->json($expenses_types);
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