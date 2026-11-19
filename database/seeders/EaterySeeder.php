<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Dish;
use App\Models\Eatery;
use App\Models\Feature;
use App\Models\Permit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EaterySeeder extends Seeder
{
    public function run(): void
    {
        // My hand-made eatery
        $poblacion = District::where('name', 'Poblacion')->first();

        $mine = Eatery::create([
            'district_id' => $poblacion->id,
            'name'        => 'Carinderia ni Cudal',
            'slug'        => Str::slug('Carinderia ni Cudal'),
            'address'     => 'San Pedro St., Poblacion, Davao City',
            'price_range' => 'budget',
            'specialty'   => 'Tinolang Manok',
            'is_open'     => true,
        ]);

        $mine->permit()->create([
            'permit_no'  => 'DVO-2026-0324',
            'expires_on' => '2027-03-24',
        ]);

        $mine->features()->sync(
            Feature::whereIn('name', ['Suki ni Cudal', 'Budget Meal'])->pluck('id')
        );

        $mine->dishes()->create(['name' => 'Tinolang Manok', 'price' => 85.00, 'is_bestseller' => true]);
        $mine->dishes()->create(['name' => 'Kinilaw na Tuna', 'price' => 120.00]);
        $mine->dishes()->create(['name' => 'Durian Shake', 'price' => 75.00]);

        // 14 factory eateries: 11 open, 3 closed
        $open   = Eatery::factory()->count(11)->create();
        $closed = Eatery::factory()->count(3)->closed()->create();
        $others = $open->merge($closed);

        $features = Feature::all();

        foreach ($others as $index => $eatery) {
            if ($index === 0) {
                // guarantee at least one expired permit
                Permit::factory()->for($eatery)->create(['expires_on' => now()->subMonth()->toDateString()]);
            } else {
                Permit::factory()->for($eatery)->create();
            }

            Dish::factory()->count(rand(2, 5))->for($eatery)->create();

            $eatery->features()->attach($features->random(rand(1, 3))->pluck('id'));
        }
    }
}