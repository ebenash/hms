<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'room_id' => $this->faker->numberBetween(1,1000),
            'room_type' => $this->faker->numberBetween(1,1000),
            'guest_id' => $this->faker->numberBetween(1,20000),
            'check_in' => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'check_out' => $this->faker->dateTimeBetween('+0 days', '+2 years'),
            'days' => 2,
            'adults' => 2,
            'children' => 1,
            'reservation_status' => $this->faker->randomElement(['confirmed','pending','cancelled']),
            'discount' => null,
            'currency' => 'GHS',
            'grand_total' => $this->faker->numberBetween(500,1500),
            'reservation_type' => 'default',
            'company_id' => 1,
            'created_by' => 1,
        ];
    }
}
