<?php

namespace Database\Seeders;

use App\Models\CharacterClass;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CharacterClassSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $classesFile = resource_path("data/classes.json");

        if (File::exists($classesFile)) {
            $classes = File::json($classesFile);

            foreach ($classes as $class) {
                CharacterClass::create([
                    'name' => $class['name'],
                    'plural_name' => $class['plural_name'],
                    'parent_id' => $class['parent_id'],
                ]);
            }
        }
    }
}
