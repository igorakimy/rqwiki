<?php

namespace Database\Seeders;

use App\Models\NpcGroups;
use App\Models\QuestChain;
use App\Models\QuestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PermissionSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);

        $this->call(CharacterClassSeeder::class);
        $this->call(LocationTypeSeeder::class);
        $this->call(ElementSeeder::class);
        $this->call(RaceSeeder::class);
        $this->call(NpcGroups::class);
        $this->call(QuestChain::class);
        $this->call(QuestType::class);
        $this->call(BonusSeeder::class);
    }
}
