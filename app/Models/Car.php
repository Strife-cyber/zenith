<?php

namespace App\Models;

use Database\Factories\CarFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static select(string[] $carColumns)
 * @method static where(string $string, String $id)
 * @method static find(String $id)
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
