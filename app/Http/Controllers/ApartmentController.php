<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Listing;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $apartments = Listing::with(['images', 'listable'])
            ->where('category', 'apartment')
            ->whereNotNull('listable_id');

        $search = $request->input('search');

        if ($search) {
            $apartments->where(function ($q) use ($search) {
                // Filter Listing fields
                $q->where('title', 'like', "%$search%")
                    ->orWhere('type', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%")
                    // Filter related Apartment (listable) fields
                    ->orWhereHas('listable', function ($q) use ($search) {
                        $q->where('bedrooms', 'like', "%$search%")
                            ->orWhere('bathrooms', 'like', "%$search%")
                            ->orWhere('size', 'like', "%$search%")
                            ->orWhere('furnished', 'like', "%$search%")
                            ->orWhere('parking', 'like', "%$search%")
                            ->orWhereJsonContains('amenities', $search);
                    });
            });
        }
        $apartments = $apartments->paginate(9)->withQueryString();

        return Inertia::render('Apartments', [
            'apartments' => $apartments,
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
    public function store(StoreApartmentRequest $request)
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

        // Create Apartment Details
        $apartment = Apartment::create([
            'bedrooms' => $fields['bedrooms'],
            'bathrooms' => $fields['bathrooms'],
            'size' => $fields['size'],
            'furnished' => $fields['furnished'],
            'parking' => $fields['parking'],
            'amenities' => json_encode($fields['amenities']), // Store amenities as JSON if it's an array
            'listing_id' => $listing->id,
        ]);

        // Associate listing with apartment
        $listing->listable()->associate($apartment);
        $listing->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment): void
    {
        $fields = $request->validated();
        $apartment->update($fields);
        $apartment->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment): void
    {
        $apartment->delete();
    }
}
