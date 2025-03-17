<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Image;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = database_path('apartments_data.json');
        $jsonData = json_decode(file_get_contents($jsonFile), true);

        if ($jsonData) {
            foreach ($jsonData as $data) {
                $listing = Listing::create([
                    'title' => 'Sample Apartment',
                    'description' => 'This is a sample apartment you might wanna say for sale',
                    'category' => 'apartment',
                    'type' => fake()->randomElement(['rent', 'sale']),
                    'price' => '$'.fake()->randomFloat(min: 10000, max: 100000),
                    'status' => 'available',
                ]);

                Image::create([
                    'image' => $data['image_url'],
                    'listing_id' => $listing->id,
                ]);

                $apartment = Apartment::create([
                    'bedrooms' => $data['bedrooms'],
                    'bathrooms' => $data['bathrooms'],
                    'size' => $data['size'],
                    'furnished' => $data['furnished'],
                    'parking' => fake()->boolean(),
                    'amenities' => json_encode($data['amenities']),
                    'listing_id' => $listing->id,
                ]);

                $listing->listable()->associate($apartment);
                $listing->save();
            }
        }
    }
}
