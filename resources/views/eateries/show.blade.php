@extends('layouts.app')

@section('title', $eatery->name . ' – Kaon Ta! Davao')

@section('content')
    @php
        $prices = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
    @endphp

    <div class="bg-white rounded shadow p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold">
                    {{ $eatery->name }}
                    @if (! $eatery->is_open)
                        <span class="bg-gray-700 text-white text-xs rounded px-2 py-0.5 align-middle">Closed</span>
                    @endif
                </h1>
                <p class="text-gray-600">
                    <a href="{{ route('districts.show', $eatery->district) }}" class="text-orange-700 hover:underline">{{ $eatery->district->name }}</a>
                    · {{ $eatery->address }}
                </p>
                <p class="text-gray-600">
                    Price range: {{ $prices[$eatery->price_range] }}
                    @if ($eatery->specialty)
                        · Specialty: {{ $eatery->specialty }}
                    @endif
                </p>
                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach ($eatery->features as $feature)
                        <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
                           class="bg-orange-100 text-orange-800 rounded px-2 py-0.5 text-xs hover:bg-orange-200">{{ $feature->name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('eateries.edit', $eatery) }}" class="bg-orange-700 text-white rounded px-4 py-2">Edit</a>
                <form method="POST" action="{{ route('eateries.destroy', $eatery) }}" onsubmit="return confirm('Delete this eatery?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white rounded px-4 py-2">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <section class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-2">Business Permit</h2>
            @if ($eatery->permit)
                <p>Permit no.: {{ $eatery->permit->permit_no }}</p>
                <p>Expires on: {{ $eatery->permit->expires_on->format('F j, Y') }}</p>
                @if ($eatery->permit->expires_on->lt(today()))
                    <p class="text-red-600 font-semibold">Permit expired</p>
                @endif
            @else
                <p class="text-gray-600">No permit on file.</p>
            @endif
        </section>

        <section class="bg-white rounded shadow p-6">
            <h2 class="text-lg font-semibold mb-2">Dishes</h2>
            <ul class="divide-y">
                @foreach ($eatery->dishes as $dish)
                    <li class="py-2 flex justify-between">
                        <span>
                            {{ $dish->name }}
                            @if ($dish->is_bestseller)
                                <span class="bg-yellow-200 text-yellow-900 text-xs rounded px-2 py-0.5">Bestseller</span>
                            @endif
                        </span>
                        <span>₱{{ number_format($dish->price, 2) }}</span>
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

    <section class="bg-white rounded shadow p-6 mb-6">
        <h2 class="text-lg font-semibold mb-3">Reviews ({{ $eatery->reviews->count() }})</h2>

        @forelse ($eatery->reviews as $review)
            <div class="border-b py-3">
                <div class="flex justify-between items-start gap-2">
                    <div>
                        <a href="{{ route('reviewers.show', $review->user) }}" class="font-semibold text-orange-700 hover:underline">{{ $review->user->name }}</a>
                        <x-rating :value="$review->rating" />
                        <span class="text-sm text-gray-500">{{ $review->created_at->format('M j, Y') }}</span>
                    </div>
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Delete this review?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 text-sm hover:underline">Delete</button>
                    </form>
                </div>
                <p class="mt-1">{{ $review->body }}</p>
            </div>
        @empty
            <p class="text-gray-600">No reviews yet.</p>
        @endforelse
    </section>

    <section class="bg-white rounded shadow p-6">
        @if ($eatery->is_open)
            <h2 class="text-lg font-semibold mb-3">Write a Review</h2>

            @if ($errors->any())
                <div class="bg-red-100 text-red-800 rounded px-4 py-2 mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('eateries.reviews.store', $eatery) }}" class="flex flex-col gap-3">
                @csrf

                <label class="flex flex-col gap-1">Reviewer
                    <select name="user_id" class="border rounded px-3 py-2">
                        <option value="">Choose a reviewer</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </label>

                <label class="flex flex-col gap-1">Rating
                    <select name="rating" class="border rounded px-3 py-2">
                        <option value="">Choose a rating</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }} {{ $i === 1 ? 'star' : 'stars' }}</option>
                        @endfor
                    </select>
                    @error('rating') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </label>

                <label class="flex flex-col gap-1">Review
                    <textarea name="body" rows="4" class="border rounded px-3 py-2">{{ old('body') }}</textarea>
                    @error('body') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </label>

                <button type="submit" class="bg-orange-700 text-white rounded px-4 py-2 self-start">Post Review</button>
            </form>
        @else
            <p class="text-gray-700">This eatery is closed. Reviews are paused.</p>
        @endif
    </section>
@endsection