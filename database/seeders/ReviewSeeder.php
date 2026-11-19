<?php

namespace Database\Seeders;

use App\Models\Eatery;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $mine  = Eatery::where('slug', 'carinderia-ni-cudal')->first();
        $tita  = User::where('email', 'tita.cudal@kaonta.test')->first();
        $me    = User::where('email', 'cudal@kaonta.test')->first();

        // At least 3 reviews on my eatery, one by Tita Cudal
        $mine->reviews()->create([
            'user_id' => $tita->id,
            'rating'  => 5,
            'body'    => 'Lami kaayo! Balik-balikan ni Tita Cudal.',
        ]);

        $mine->reviews()->create([
            'user_id' => $me->id,
            'rating'  => 4,
            'body'    => 'Write your own short review here.',
        ]);

        $mine->reviews()->create([
            'user_id' => $users->random()->id,
            'rating'  => 5,
            'body'    => 'Write another short review here.',
        ]);

        // 0-6 reviews on each open factory eatery, none on closed ones
        $openOthers = Eatery::where('is_open', true)->where('id', '!=', $mine->id)->get();

        foreach ($openOthers as $eatery) {
            Review::factory()
                ->count(rand(0, 6))
                ->for($eatery)
                ->sequence(fn ($seq) => ['user_id' => $users->random()->id])
                ->create();
        }
    }
}