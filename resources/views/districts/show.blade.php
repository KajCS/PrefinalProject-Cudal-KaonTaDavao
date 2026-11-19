@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $district->name }}</h1>
    <p class="text-gray-600 mb-4">{{ $district->reviews_count }} {{ $district->reviews_count == 1 ? 'review' : 'reviews' }} in {{ $district->name }}</p>

    @if ($eateries->isEmpty())
        <p class="text-gray-600">No eateries in this district yet.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($eateries as $eatery)
                <x-eatery-card :eatery="$eatery" />
            @endforeach
        </div>
    @endif
@endsection