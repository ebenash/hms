<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomsFactory extends Factory
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
            'room_type_id' => $this->number++,
            'status' => 1,
            'company_id' => 1,
            'created_by' => 1,
        ];
    }
}
