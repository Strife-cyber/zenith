<?php

use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    $listings = Listing::with('images')
        ->inRandomOrder()
        ->paginate(9);

    return Inertia::render('Dashboard', [
        'listings' => $listings,
    ]);
})->middleware(['auth'])->name('dashboard');

Route::get('vehicles', function (Request $request) {
    $vehicles = Listing::with(['images', 'listable'])
        ->where('category', 'car');

    $search = $request->input('search');

    if ($search) {
        $vehicles->where(function ($query) use ($search) {
            $query->orWhereHas('listable', function ($query) use ($search) {
                $query->where('make', 'like', '%' . $search . '%');
                $query->orWhere('model', 'like', '%' . $search . '%');
                $query->orWhere('year', 'like', '%' . $search . '%');
                $query->orWhere('transmission', 'like', '%' . $search . '%');
                $query->orWhere('fuel', 'like', '%' . $search . '%');
                $query->orWhere('condition', 'like', '%' . $search . '%');
            });
        });
    }


    $vehicles = $vehicles->paginate(9)->withQueryString();

    return Inertia::render('Vehicles', [
        'vehicles' => $vehicles,
    ]);
})->middleware(['auth'])->name('vehicles');

Route::get('apartments', function (Request $request) {
    $apartments = Listing::with(['images', 'listable'])
        ->where('category', 'apartment')
        ->whereNotNull('listable_id');

    $search = $request->input('search');

    if ($search) {
        $apartments->where(function ($q) use ($search) {
            // Filter Listing fields
            $q->where('title', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('price', 'like', "%{$search}%")
                // Filter related Apartment (listable) fields
                ->orWhereHas('listable', function ($q) use ($search) {
                    $q->where('bedrooms', 'like', "%{$search}%")
                        ->orWhere('bathrooms', 'like', "%{$search}%")
                        ->orWhere('size', 'like', "%{$search}%")
                        ->orWhere('furnished', 'like', "%{$search}%")
                        ->orWhere('parking', 'like', "%{$search}%")
                        ->orWhereJsonContains('amenities', $search);
                });
        });
    }
    $apartments = $apartments->paginate(9)->withQueryString();

    return Inertia::render('Apartments', [
        'apartments' => $apartments,
    ]);
})->middleware(['auth'])->name('apartments');

Route::get('lands', function (Request $request) {
    $lands = Listing::with(['images', 'listable'])
        ->where('category', 'land')
        ->whereNotNull('listable_id');

    $search = $request->input('search');

    if ($search) {
        $lands->where(function ($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('price', 'like', "%{$search}%")
                ->orWhereHas('listable', function ($query) use ($search) {
                $query->where('size', 'like', "%{$search}%")
                    ->orWhere('zoning', 'like', "%{$search}%")
                    ->orWhere('document', 'like', "%{$search}%");
            });
        });
    }
    $lands = $lands->paginate(9)->withQueryString();

    return Inertia::render('Lands', [
        'lands' => $lands,
    ]);
})->middleware(['auth'])->name('lands');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
