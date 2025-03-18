<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'string|max:255',
            'email' => 'string|lowercase|email|max:255|unique:'.User::class,
            'admin' => 'boolean'
        ]);

        $user->update($fields);
        $user->save();

        return response()->json($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        try{
            $user->delete();
            return response()->json(['User removed successfully'], 204);
        } catch (QueryException $e) {
            return response()->json($e->getMessage(), 403);
        }
    }
}
