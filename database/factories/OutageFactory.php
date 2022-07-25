<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Outage>
 */
class OutageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start' => $this->faker->dateTime,
            'end' => $this->faker->dateTime,
            'area' => $this->faker->city,
            'address' => $this->faker->text(200)
        ];
    }
}
