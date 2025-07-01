<?php

namespace Database\Seeders;

use App\Models\Race;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class RaceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $racesFile = resource_path('data/races.json');

        $races = File::json($racesFile);

        foreach ($races as $race) {
            Race::create([
                'name' => $race['name'],
            ]);
        }
    }
}
