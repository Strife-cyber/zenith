<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Land;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class LandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generate 20 fake land listings
        for ($i = 0; $i < 10; $i++) {
            // Create a Listing for the land
            $listing = Listing::create([
                'title' => fake()->unique()->words(3, true) . ' Land', // e.g., "Scenic Hill Land"
                'description' => fake()->sentence(10),
                'category' => 'land',
                'type' => 'sale',
                'price' => '$'.fake()->numberBetween(50000, 5000000), // $50K to $5M
                'status' => fake()->randomElement(['available', 'pending', 'sold']),
            ]);

            // Add fake images (1-3 per listing)
            $imageCount = fake()->numberBetween(1, 3);
            for ($j = 0; $j < $imageCount; $j++) {
                Image::create([
                    'image' => fake()->imageUrl(300, 200, 'nature', true, $listing->title),
                    'listing_id' => $listing->id,
                ]);
            }

            // Create the Land and associate it
            $land = Land::create([
                'listing_id' => $listing->id,
                'size' => fake()->randomFloat(2, 0.5, 1000), // 0.5 to 1000 acres
                'zoning' => fake()->randomElement(['residential', 'commercial', 'agricultural']),
                'document' => fake()->boolean(80), // 80% chance of having documents
            ]);

            $listing->listable()->associate($land);
            $listing->save();
        }
    }
}
