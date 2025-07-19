<?php

namespace Database\Seeders;

use App\Enums\MediaCollectionEnum;
use App\Models\Image;
use App\Models\Location;
use App\Models\WorldMap;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class WorldMapSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileDoesNotExist|FileIsTooBig
     * @throws FileNotFoundException
     */
    public function run(): void
    {
//        $image = Image::create([
//            'name' => 'Карта мира'
//        ]);
//
//        $imageFiles = File::allFiles(resource_path('images/world_map'));
//
//        $image->addMedia($imageFiles[0])
//            ->preservingOriginal()
//            ->toMediaCollection(MediaCollectionEnum::WORLD_MAP->value);

//        $worldMap = WorldMap::create([
//            'name' => 'Карта мира',
//            'image_id' => $image->id,
//        ]);
        $worldMap = WorldMap::first();

        $worldMapLocations = collect(File::json(resource_path('data/world_map_locations.json')));
        $locations = Location::whereIn(
            'name',
            $worldMapLocations->pluck('name')->toArray()
        )->get();
        $locationCoords = $worldMapLocations->pluck('coords', 'name')->toArray();
        $synced = [];
        foreach ($locations as $location) {
            $synced[$location->id] = [
                'coords' => $locationCoords[$location->name],
            ];
        }

        $worldMap->locations()->sync($synced);
    }
}
