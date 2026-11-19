<?php

namespace App\Http\Controllers;

use App\Models\User;

class ReviewerController extends Controller
{
    public function show(User $user)
    {
        $user->loadCount('reviews');
        $user->load([
            'reviews' => function ($query) {
                $query->latest()->with('eatery');
            },
        ]);

        return view('reviewers.show', ['user' => $user]);
    }
}