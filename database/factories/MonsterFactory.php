<?php

namespace Database\Factories;

use App\Enums\MonsterDefenceEnum;
use App\Enums\MonsterModeEnum;
use App\Models\Monster;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Monster>
 */
class MonsterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hp = $this->faker->numberBetween(90, 178354704);
        $xp = $this->faker->numberBetween(0, 598920);

        return [
            'name' => $this->faker->unique()->words(1, true),
            'level' => $this->faker->numberBetween(1, 68),
            'health_points' => $hp,
            'element_strength' => $this->faker->numberBetween(1, 3),
            'element_id' => $this->faker->numberBetween(1, 7),
            'is_aggressive' => $this->faker->boolean(),
            'is_elite' => $this->faker->boolean(30),
            'is_boss' => $this->faker->boolean(10),
            'pick_up_loot' => $this->faker->boolean(10),
            'shield' => 0,
            'defence' => $this->faker->randomElement(MonsterDefenceEnum::values()),
            'experience' => $xp,
            'xp_per_hp' => round($xp / $hp, 2),
            'combat_mode' => $this->faker->randomElement(MonsterModeEnum::values()),
            'quest_only' => $this->faker->boolean(7),
            'race_id' => $this->faker->numberBetween(1, 11),
            'image_id' => 1,
            'big_image_id' => 1,
        ];
    }
}
