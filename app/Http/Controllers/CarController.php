<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Image;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRequest;
use App\Http\Requests\UpdateCarRequest;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
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
    public function store(StoreCarRequest $request)
    {
        $fields = $request->validated();

        // Create Listing
        $listing = Listing::create([
            'title' => $fields['title'],
            'description' => $fields['description'],
            'category' => $fields['category'],
            'type' => $fields['type'],
            'price' => '$'.$fields['price'], // Store as a number
            'status' => $fields['status'],
        ]);

        // Store images and associate them with the listing
        if (!empty($fields['images'])) {
            foreach ($fields['images'] as $image) {
                $path = $image->store('images', 'public'); // Use $image instead of $request->file('image')
                $url = asset("storage/{$path}");

                Image::create([
                    'listing_id' => $listing->id,
                    'image' => $url,
                ]);
            }
        }

        $car = Car::create([
            'make' => $fields['make'],
            'model' => $fields['model'],
            'year' => $fields['year'],
            'fuel' => $fields['fuel'],
            'transmission' => $fields['transmission'],
            'condition' => $fields['condition'],
            'listing_id' => $listing->id,
        ]);

        $listing->listable()->associate($car);
        $listing->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarRequest $request, String $id): void
    {
        $car = Car::find($id);
        $fields = $request->validated();
        $car->update($fields);
        $car->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(String $id): void
    {
        $car = Car::where('id', $id);
        $car->delete();
    }
}
