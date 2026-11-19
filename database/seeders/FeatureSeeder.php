<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Suki ni Cudal', 'Budget Meal', 'Halal', 'Open 24 Hours', 'Aircon', 'Free Wi-Fi'];

        foreach ($names as $name) {
            Feature::create(['name' => $name]);
        }
    }
}