<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Image;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonFile = database_path('vehicles_data.json');
        $jsonData = json_decode(file_get_contents($jsonFile), true);

        if ($jsonData) {
            foreach ($jsonData as $data) {
                $listing = Listing::create([
                    'title' => 'Sample Car',
                    'description' => 'This is a sample car not for sale but used to test the app',
                    'category' => 'car',
                    'type' => 'rent',
                    'price' => $data['price'],
                    'status' => 'available',
                ]);

                foreach ($data['image_url'] as $image) {
                    Image::create([
                        'image' => $image,
                        'listing_id' => $listing->id,
                    ]);
                }

                $car = Car::create([
                    'listing_id' => $listing->id,
                    'make' => $data['make'],
                    'model' => $data['model'],
                    'year' => $data['year'],
                    'fuel' => 'petrol',
                    'transmission' => 'automatic',
                    'condition' => 'new',
                ]);

                $listing->listable()->associate($car);
                $listing->save();
            }
        }
    }
}
