<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Eben Ash',
            'email' => 'ebenezer.ashiakwei@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$esSZrwPgI9Icg6sQfsiW.OwlGveOfC8nFZoZcNgPB8xqSvucXYYzy', // i10
            'remember_token' => Str::random(10),
            'title' => 'Admin',
            'company_id' => 1,
            'phone' => $this->faker->phoneNumber(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
