<?php

namespace Database\Factories;

use App\Enums\EquipmentItemClassEnum;
use App\Enums\EquipmentTypeEnum;
use App\Enums\GenderEnum;
use App\Models\Equipment;
use App\Models\EquipmentType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $equipmentTypes = EquipmentType::where('type', EquipmentTypeEnum::EQUIPMENT)
            ->get()
            ->pluck('id')
            ->toArray();

        return [
            'name' => $this->faker->unique()->words(2, true),
            'image_id' => 1,
            'equipment_type_id' => $this->faker->randomElement($equipmentTypes),
            'item_class' => $this->faker->randomElement(EquipmentItemClassEnum::values()),
            'required_level' => $this->faker->numberBetween(1, 70),
            'max_slots_amount' => 1,
            'defence' => $this->faker->numberBetween(0, 1200),
            'gender' => $this->faker->randomElement(GenderEnum::values()),
            'selling_price' => $this->faker->numberBetween(0, 1000),
            'description' => $this->faker->text(),
        ];
    }
}
