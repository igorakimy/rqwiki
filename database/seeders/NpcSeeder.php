<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Location;
use App\Models\Npc;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NpcSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 200; $i++) {
            $locationIds = Location::query()
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, 4))
                ->pluck('id')
                ->toArray();

            $categoryIds = Category::query()
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, 3))
                ->pluck('id')
                ->toArray();

            /** @var Npc $npc */
            $npc = Npc::factory()->create();

            $npc->locations()->sync($locationIds);

            $npc->npc_groups()->sync([fake()->numberBetween(1, 4)]);

            $npc->categories()->sync($categoryIds);
        }
    }
}
