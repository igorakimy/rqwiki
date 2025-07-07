<?php

namespace Database\Seeders;

use App\Models\Bonus;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class BonusSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $bonusesFile = resource_path('data/bonuses.json');

        $bonuses = File::json($bonusesFile);

        foreach ($bonuses as $bonus) {
            Bonus::create([
                'name' => $bonus['name'],
                'name_formatted' => $bonus['name_formatted'],
                'name_alt' => $bonus['name_alt'],
                'name_alt_formatted' => $bonus['name_alt_formatted'],
                'is_pvp' => $bonus['is_pvp'],
                'description' => $bonus['description'],
            ]);
        }
    }
}
