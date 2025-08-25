<?php

namespace Database\Seeders;

use App\Enums\BonusesValueTypeEnum;
use App\Models\Bonus;
use App\Models\Category;
use App\Models\CharacterClass;
use App\Models\Equipment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 200; $i++) {
            $charClasses = CharacterClass::inRandomOrder()
                ->limit(fake()->numberBetween(0, 8))
                ->get()
                ->pluck('id')
                ->toArray();

            $bonuses = Bonus::inRandomOrder()
                ->limit(fake()->numberBetween(1, 4))
                ->get();

            /** @var Equipment $equipment */
            $equipment = Equipment::factory()->create();

            $equipment->classes()->sync($charClasses);

            $categoryId = Category::where('name', 'Экипировка')->first()?->id;
            $equipment->categories()->sync([$categoryId]);

            $bonusesArr = [];
            foreach ($bonuses as $index => $bonus) {
                $bonusesArr[$bonus->id] = [
                    'value' => fake()->numberBetween(1, 50),
                    'value_type' => fake()->randomElement(BonusesValueTypeEnum::values()),
                    'order' => $index + 1,
                ];
            }
            $equipment->bonuses()->sync($bonusesArr);
        }
    }
}
