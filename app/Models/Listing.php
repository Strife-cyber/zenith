<?php

namespace App\Models;

use Database\Factories\ListingFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method static create(array $array)
 * @method static paginate(int $int)
 * @method static select(array $columns)
 */
class Listing extends Model
{
    /** @use HasFactory<ListingFactory> */
    use HasFactory;

    protected $fillable = [
        'title', 'description',
        'category', 'type', 'price', 'status'
    ];

    public function listable(): MorphTo
    {
        return $this->morphTo();
    }

    public function images(): HasMany
    {
        return $this->HasMany(Image::class);
    }

    public function review(): HasMany
    {
        return $this->HasMany(Review::class);
    }

    public function transactions(): HasMany
    {
        return $this->HasMany(Transaction::class);
    }
}
