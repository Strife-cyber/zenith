<?php

namespace App\Models;

use Database\Factories\LandFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static select(string[] $landColumns)
 */
class Land extends Model
{
    /** @use HasFactory<LandFactory> */
    use HasFactory;

    protected $fillable = [
        'size', 'zoning', 'document', 'listing_id'
    ];

    public function listing(): MorphOne
    {
        return $this->MorphOne(Listing::class, 'listable');
    }
}
