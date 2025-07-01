<?php

namespace Database\Seeders;

use App\Models\LocationType;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LocationTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $locationTypeFile = resource_path('data/location_types.json');

        $locationTypes = File::json($locationTypeFile);

        foreach ($locationTypes as $locationType) {
            LocationType::create([
                'name' => $locationType['name'],
            ]);
        }
    }
}
