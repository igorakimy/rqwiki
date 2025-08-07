<?php

namespace Database\Seeders;

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

        $this->call(CategorySeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(CharacterClassSeeder::class);
        $this->call(LocationTypeSeeder::class);
        $this->call(LocationSeeder::class);
        $this->call(WorldMapSeeder::class);
        $this->call(ElementSeeder::class);
        $this->call(RaceSeeder::class);
        $this->call(MonsterSeeder::class);
        $this->call(NpcGroupsSeeder::class);
        $this->call(NpcSeeder::class);
        $this->call(QuestChainSeeder::class);
        $this->call(QuestTypeSeeder::class);
        $this->call(QuestSeeder::class);
        $this->call(BonusSeeder::class);
        $this->call(EquipmentTypesSeeder::class);
    }
}
