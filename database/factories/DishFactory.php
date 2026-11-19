<?php

namespace Database\Factories;

use App\Models\Eatery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dish>
 */
class DishFactory extends Factory
{
    public function definition(): array
    {
        return [
            'eatery_id'     => Eatery::factory(),
            'name'          => fake()->randomElement(['Adobong Manok', 'Sinigang na Baboy', 'Tinolang Isda', 'Pork Barbecue', 'Laing', 'Halo-halo', 'Lumpia']),
            'price'         => fake()->randomFloat(2, 40, 350),
            'is_bestseller' => false,
        ];
    }
}