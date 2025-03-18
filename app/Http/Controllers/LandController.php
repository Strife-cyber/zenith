<?php

namespace App\Http\Controllers;

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
        //
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
    public function update(UpdateLandRequest $request, Land $land)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Land $land)
    {
        //
    }
}
