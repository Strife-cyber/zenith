<?php

namespace App\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static select(string[] $carColumns)
 */
class Car extends Model
{
    /** @use HasFactory<CarFactory> */
    use HasFactory;

    protected $fillable = [
        'make', 'model', 'year',
        'transmission', 'fuel', 'condition', 'listing_id'
    ];

    public function listing(): MorphOne
    {
        return $this->morphOne(Listing::class, 'listable');
    }
}
