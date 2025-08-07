<?php

namespace Database\Seeders;

use App\Models\Quest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 200; $i++) {
            /** @var Quest $quest */
            $quest = Quest::factory()->create();

            $prevQuestsIds = Quest::where('id', '!=', $quest->id)
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, 2))
                ->pluck('id')
                ->toArray();

            $nextQuestsIds = Quest::where('id', '!=', $quest->id)
                ->whereNotIn('id', $prevQuestsIds)
                ->inRandomOrder()
                ->limit(fake()->numberBetween(1, 2))
                ->pluck('id')
                ->toArray();

            $quest->prev_quests()->sync($prevQuestsIds);
            $quest->next_quests()->sync($nextQuestsIds);
        }
    }
}
