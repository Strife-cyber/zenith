<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\LandController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Inertia\Inertia;
use App\Models\Listing;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        $listings = Listing::with('images')
            ->inRandomOrder()
            ->paginate(9);

        return Inertia::render('Dashboard', [
            'listings' => $listings,
        ]);
    })->name('dashboard');

    Route::resource('users', UserController::class);
    Route::resource('admin', AdminController::class);
    Route::resource('listings', ListingController::class);

    Route::resource('lands', LandController::class)->name('index', 'lands');
    Route::resource('vehicles', CarController::class)->name('index', 'vehicles');
    Route::resource('apartments', ApartmentController::class)->name('index', 'apartments');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
