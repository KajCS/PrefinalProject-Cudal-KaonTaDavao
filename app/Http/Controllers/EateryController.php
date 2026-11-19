<?php

namespace App\Http\Controllers;

use App\Models\Eatery;
use App\Http\Requests\StoreEateryRequest;
use App\Http\Requests\UpdateEateryRequest;
use App\Models\District;
use App\Models\Feature;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EateryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $eateries = Eatery::with(['district', 'features'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->when($request->q, function ($query, $q) {
                $query->where(function ($query) use ($q) {
                    $query->where('name', 'like', "%{$q}%")
                        ->orWhere('specialty', 'like', "%{$q}%");
                });
            })
            ->when($request->district, function ($query, $district) {
                $query->where('district_id', $district);
            })
            ->when($request->feature, function ($query, $feature) {
                $query->whereHas('features', function ($query) use ($feature) {
                    $query->where('name', $feature);
                });
            })
            ->orderBy('name')
            ->paginate(6)
            ->withQueryString();

        return view('eateries.index', [
            'eateries' => $eateries,
            'districts' => District::orderBy('name')->get(),
            'features' => Feature::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('eateries.create', [
            'eatery' => new Eatery(['is_open' => true]),
            'districts' => District::orderBy('name')->get(),
            'features' => Feature::orderBy('name')->get(),
            'selectedFeatures' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEateryRequest $request)
    {
        $data = $request->validated();

        $eatery = Eatery::create([
            'district_id' => $data['district_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'price_range' => $data['price_range'],
            'specialty' => $data['specialty'] ?? null,
            'is_open' => $request->boolean('is_open'),
        ]);

        $eatery->permit()->create([
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery added.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Eatery $eatery)
    {
        $eatery->load([
            'district',
            'permit',
            'dishes',
            'features',
            'reviews' => function ($query) {
                $query->latest()->with('user');
            },
        ]);

        return view('eateries.show', [
            'eatery' => $eatery,
            'users' => User::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Eatery $eatery)
    {
        $eatery->load(['permit', 'features']);

        return view('eateries.edit', [
            'eatery' => $eatery,
            'districts' => District::orderBy('name')->get(),
            'features' => Feature::orderBy('name')->get(),
            'selectedFeatures' => $eatery->features->pluck('id')->all(),
        ]);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEateryRequest $request, Eatery $eatery)
    {
        $data = $request->validated();

        $eatery->update([
            'district_id' => $data['district_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'address' => $data['address'],
            'price_range' => $data['price_range'],
            'specialty' => $data['specialty'] ?? null,
            'is_open' => $request->boolean('is_open'),
        ]);

        $eatery->permit()->updateOrCreate([], [
            'permit_no' => $data['permit_no'],
            'expires_on' => $data['expires_on'],
        ]);

        $eatery->features()->sync($data['features']);

        return redirect()->route('eateries.show', $eatery)->with('status', 'Eatery updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Eatery $eatery)
    {
        $eatery->permit()->delete();
        $eatery->dishes()->delete();
        $eatery->reviews()->delete();
        $eatery->features()->detach();
        $eatery->delete();

        return redirect()->route('eateries.index')->with('status', 'Eatery deleted.');
    }
}
