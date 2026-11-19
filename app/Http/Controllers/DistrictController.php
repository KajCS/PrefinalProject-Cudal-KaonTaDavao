<?php

namespace App\Http\Controllers;

use App\Models\District;

class DistrictController extends Controller
{
    public function index()
    {
        $districts = District::withCount('eateries')->orderBy('name')->get();

        return view('districts.index', ['districts' => $districts]);
    }

    public function show(District $district)
    {
        $district->loadCount('reviews');

        $eateries = $district->eateries()
            ->with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->orderBy('name')
            ->get();

        return view('districts.show', [
            'district' => $district,
            'eateries' => $eateries,
        ]);
    }
}
