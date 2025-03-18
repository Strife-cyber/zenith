<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use App\Models\Car;
use App\Models\Land;
use App\Models\Listing;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response|RedirectResponse
    {
        $user = auth()->user();
        $columns = ['id', 'title', 'description', 'category', 'type', 'price', 'status'];
        $apartColumns = ['id', 'bedrooms', 'bathrooms', 'size', 'furnished', 'parking', 'amenities'];
        $carColumns = ['id', 'make', 'model', 'year', 'transmission', 'fuel', 'condition'];
        $landColumns = ['id', 'size', 'zoning', 'document'];
        $userColumns = ['id', 'name', 'email', 'phone', 'admin'];

        $users = User::select($userColumns)->where('admin', false)->get();
        $listings = Listing::select($columns)->get();
        $apartments = Apartment::select($apartColumns)->get();
        $cars = Car::select($carColumns)->get();
        $lands = Land::select($landColumns)->get();

        return $user['admin'] ? Inertia::render('Admin', [
            'users' => $users,
            'listings' => $listings,
            'apartments' => $apartments,
            'cars' => $cars,
            'lands' => $lands,
        ]) : redirect()->route('404');
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
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
