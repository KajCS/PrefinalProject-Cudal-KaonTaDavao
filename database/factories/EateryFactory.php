<?php

namespace Database\Factories;

use App\Models\District;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Eatery>
 */
class EateryFactory extends Factory
{
    public function definition(): array
    {
        $name = 'Kan-anan ni ' . fake()->unique()->firstName();

        return [
            'district_id' => District::inRandomOrder()->value('id'),
            'name'        => $name,
            'slug'        => Str::slug($name),
            'address'     => fake()->streetAddress() . ', Davao City',
            'price_range' => fake()->randomElement(['budget', 'mid', 'splurge']),
            'specialty'   => fake()->randomElement(['Sinugba', 'Kinilaw', 'Pancit Bisaya', 'Lechon Manok', 'Bulalo', null]),
            'is_open'     => true,
        ];
    }

    public function closed(): static
    {
        return $this->state(fn () => ['is_open' => false]);
    }
}