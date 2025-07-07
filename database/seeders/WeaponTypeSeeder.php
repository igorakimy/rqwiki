<?php

namespace Database\Seeders;

use App\Models\WeaponType;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WeaponTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $weaponTypesFile = resource_path('data/weapon_types.json');

        $weaponTypes = File::json($weaponTypesFile);

        foreach ($weaponTypes as $weaponType) {
            WeaponType::create([
                'name' => $weaponType['name'],
                'plural_name' => $weaponType['plural_name'],
            ]);
        }
    }
}
