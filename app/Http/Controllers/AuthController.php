<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{


    public function login(Request $request)
    {
        // Get user input from the request
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            $token = Str::random(60);

            // Save the token to the user's api_token field
            $user->api_token = $token;
            $user->save();
            $user->abilities = [
                'action'  => "manage",
                'subject' => "all",
            ];
            return response()->json([
                'user'  => $user,
                'token' => $user->api_token,
            ]);


        }

        // Handle authentication failure
        return response()->json(['message' => 'Invalid credentials', 'data' => $credentials], 401);
    }



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