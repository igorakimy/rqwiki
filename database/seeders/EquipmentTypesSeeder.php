<?php

namespace Database\Seeders;

use App\Models\EquipmentType;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EquipmentTypesSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $equipmentTypesFile = resource_path('data/equipment_types.json');

        $equipmentTypes = File::json($equipmentTypesFile);

        foreach ($equipmentTypes as $equipmentType) {
            EquipmentType::create([
                'name' => $equipmentType['name'],
                'plural_name' => $equipmentType['plural_name'],
            ]);
        }
    }
}
