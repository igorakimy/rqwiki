<?php

namespace Database\Seeders;

use App\Models\QuestType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestTypeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questTypes = [
            'Обычное',
            'Ежедневное',
            'Повторяемое',
        ];

        foreach ($questTypes as $questType) {
            QuestType::create([
                'name' => $questType
            ]);
        }
    }
}
