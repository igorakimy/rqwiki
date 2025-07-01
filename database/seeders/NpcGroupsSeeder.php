<?php

namespace Database\Seeders;

use App\Models\NpcGroups;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class NpcGroupsSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $npcGroupsFile = resource_path('data/npc_groups.json');

        $npcGroups = File::json($npcGroupsFile);

        foreach ($npcGroups as $npcGroup) {
            NpcGroups::create([
                'name' => $npcGroup['name'],
                'plural_name' => $npcGroup['plural_name'],
                'description' => $npcGroup['description'],
            ]);
        }
    }
}
