<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomTypesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public $number = 1;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price_from' => $this->faker->numberBetween(300,1500),
            'max_persons' => $this->faker->numberBetween(1,5),
            'bed_type' => '1 Normal Bed',
            'category' => $this->faker->randomElement(['room','suite']),
            'size' => null,
            'image_one' => null,
            'image_two' => null,
            'image_three' => null,
            'description' => "The Description",
            'company_id' => 1,
            'created_by' => 1,
        ];
    }
}
