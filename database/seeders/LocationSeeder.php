<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Image;
use App\Models\Location;
use App\Models\LocationType;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LocationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $locationsFile = resource_path('data/locations.json');

        $locations = File::json($locationsFile);

        foreach ($locations as $location) {
            $locationImage = Image::where('name', $location['image'])->first();

            $locationInst = Location::create([
                'name' => $location['name'],
                'description' => $location['description'],
                'image_id' => $locationImage,
            ]);

            $locationTypesIds = LocationType::whereIn('name', $location['types'])
                ->pluck('id')
                ->toArray();

            $locationInst->locations_types()->sync($locationTypesIds);

            $locationCategories = Category::whereIn('name', $location['categories'])
                ->pluck('id')
                ->toArray();

            $locationInst->categories()->sync($locationCategories);
        }
    }
}
