<?php

namespace Database\Factories;

use App\Models\Npc;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Npc>
 */
class NpcFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'image_id' => 1,
        ];
    }
}
