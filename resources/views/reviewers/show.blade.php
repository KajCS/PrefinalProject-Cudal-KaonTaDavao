@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
    <p class="text-gray-600 mb-4">{{ $user->reviews_count }} {{ $user->reviews_count == 1 ? 'review' : 'reviews' }} written</p>

    @forelse ($user->reviews as $review)
        <div class="bg-white rounded shadow p-4 mb-3">
            <a href="{{ route('eateries.show', $review->eatery) }}" class="font-semibold text-orange-700 hover:underline">{{ $review->eatery->name }}</a>
            <x-rating :value="$review->rating" />
            <p class="mt-1">{{ $review->body }}</p>
        </div>
    @empty
        <p class="text-gray-600">This reviewer has no reviews yet.</p>
    @endforelse
@endsection