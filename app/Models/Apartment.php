<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\ApartmentFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static select(string[] $apartColumns)
 */
class Apartment extends Model
{
    /** @use HasFactory<ApartmentFactory> */
    use HasFactory;

    protected $fillable = [
        'listing_id', 'bedrooms', 'bathrooms',
        'size', 'furnished', 'parking', 'amenities',
    ];

    public function listing(): MorphOne
    {
        return $this->morphOne(Listing::class, 'listable');
    }
}
