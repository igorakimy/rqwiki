<?php

namespace Database\Factories;

use App\Models\Quest;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Quest>
 */
class QuestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => Str::ucfirst($this->faker->words(asText: true)),
            'required_level' => $this->faker->numberBetween(1, 65),
            'gold' => $this->faker->numberBetween(200, 70000),
            'experience' => $this->faker->numberBetween(5, 10000000),
            'condition' => $this->faker->text(100),
            'condition_description' => $this->faker->text(),
            'explanation' => $this->faker->text($this->faker->numberBetween(80, 300)),
            'quest_type_id' => $this->faker->numberBetween(1, 3),
            'quest_chain_id' => $this->faker->numberBetween(1, 23),
            'npc_from_id' => $this->faker->numberBetween(1, 3),
            'npc_to_id' => $this->faker->numberBetween(4, 10),
        ];
    }
}
