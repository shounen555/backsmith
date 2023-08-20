<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = Group::with(['class'])->get(); // Retrieve all groups from the "groups" table

        return response()->json($groups); // Return the groups as a JSON response
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string',
            'class_id' => 'required',
        ]);





        // Create a new Tutor instance with the validated tutor data
        $group = new Group($validatedData);

        // Save the student to the database
        $group->save();
        // Return a JSON response indicating success
        return response()->json(['group' => $group], 201);
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
        $group = Group::find($id);

        // Delete the group
        $group->delete();

        // Return a response indicating success
        return response()->json(['message' => 'Group deleted successfully']);
    }
}
