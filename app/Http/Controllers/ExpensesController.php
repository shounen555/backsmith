<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expense::with('expenseType', 'raison')->orderByDesc('created_at')->get(); // Eager load the "expense type" relationship
        return response()->json($expenses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'date'        => 'required|date',
            'montant'     => 'required|numeric',
            'type_id'     => 'required|exists:expenses_types,id',
            'raison_id'   => 'nullable|exists:raisons,id',
            'raison_text' => 'nullable|required_if:raison_id,null',
            'observation' => 'nullable|string',
        ]);

        // Create a new expense record
        $expense = Expense::create($validatedData);

        // Optionally, you can return the newly created expense as a JSON response
        return response()->json(['expense' => $expense], 201);
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
        $expense = Expense::find($id);

        // Delete the expense
        $expense->delete();

        // Return a response indicating success
        return response()->json(['message' => 'expense deleted successfully']);
    }
}
