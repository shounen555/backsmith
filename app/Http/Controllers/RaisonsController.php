<?php

namespace App\Http\Controllers;

use App\Models\Raison;
use Illuminate\Http\Request;

class RaisonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raisons = Raison::all();
        return response()->json($raisons);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name'    => 'required|string',
        ]);





        // Create a new Tutor instance with the validated tutor data
        $raison = new Raison($validatedData);

        // Save the student to the database
        $raison->save();
        // Return a JSON response indicating success
        return response()->json(['raison' => $raison], 201);
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
        $raison = Raison::find($id);

        // Delete the raison
        $raison->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Raison deleted successfully']);
    }
}
