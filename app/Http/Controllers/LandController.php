<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Land;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLandRequest;
use App\Http\Requests\UpdateLandRequest;

class LandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $lands = Listing::with(['images', 'listable'])
            ->where('category', 'land')
            ->whereNotNull('listable_id');

        $search = $request->input('search');

        if ($search) {
            $lands->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('type', 'like', "%$search%")
                    ->orWhere('price', 'like', "%$search%")
                    ->orWhereHas('listable', function ($query) use ($search) {
                        $query->where('size', 'like', "%$search%")
                            ->orWhere('zoning', 'like', "%z$search%")
                            ->orWhere('document', 'like', "%$search%");
                    });
            });
        }
        $lands = $lands->paginate(9)->withQueryString();

        return Inertia::render('Lands', [
            'lands' => $lands,
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
    public function store(StoreLandRequest $request)
    {
        try {
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

            $land = Land::create([
                'listing_id' => $listing->id,
                'size' => $fields['size'],
                'zoning' => $fields['zoning'],
                'document' => $fields['document'],
            ]);

            $listing->listable()->associate($land);
            $listing->save();
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Land $land)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Land $land)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLandRequest $request, Land $land): void
    {
        $fields = $request->validated();
        $land->update($fields);
        $land->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Land $land): void
    {
        $land->delete();
    }
}
