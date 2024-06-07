<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(asText:true),
            'image' => 'event.png',
            'location' => fake()->streetAddress(),
            'date' => fake()->date(),
            'time' => fake()->time(),
            'price' => fake()->numberBetween(0, 200000),
        ];
    }
}
