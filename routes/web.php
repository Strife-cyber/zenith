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
        Route::get('lands', [LandController::class, 'index'])->name('lands');
        Route::get('vehicles', [CarController::class, 'index'])->name('vehicles');
        Route::get('apartments', [ApartmentController::class, 'index'])->name('apartments');

        Route::apiResource('lands', LandController::class);
        Route::apiResource('vehicles', CarController::class);
        Route::apiResource('listings', ListingController::class);
        Route::apiResource('apartments', ApartmentController::class);

        Route::apiResource('admin', AdminController::class);
        Route::apiResource('users', UserController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
