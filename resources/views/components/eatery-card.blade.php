@props(['eatery'])

@php
    $prices = ['budget' => '₱', 'mid' => '₱₱', 'splurge' => '₱₱₱'];
@endphp

<article class="bg-white rounded shadow p-4 flex flex-col gap-2">
    <div class="flex items-start justify-between gap-2">
        <h2 class="font-semibold text-lg">
            <a href="{{ route('eateries.show', $eatery) }}" class="hover:underline">{{ $eatery->name }}</a>
        </h2>
        @if (! $eatery->is_open)
            <span class="bg-gray-700 text-white text-xs rounded px-2 py-0.5">Closed</span>
        @endif
    </div>

    <p class="text-sm text-gray-600">
        <a href="{{ route('districts.show', $eatery->district) }}" class="text-orange-700 hover:underline">{{ $eatery->district->name }}</a>
        · {{ $prices[$eatery->price_range] }}
        @if ($eatery->specialty)
            · {{ $eatery->specialty }}
        @endif
    </p>

    <p class="text-sm">
        @if ($eatery->reviews_count > 0)
            <x-rating :value="$eatery->reviews_avg_rating" />
            {{ number_format($eatery->reviews_avg_rating, 1) }} ★ ({{ $eatery->reviews_count }} {{ $eatery->reviews_count === 1 ? 'review' : 'reviews' }})
        @else
            No reviews yet
        @endif
    </p>

    <div class="flex flex-wrap gap-1">
        @foreach ($eatery->features as $feature)
            <a href="{{ route('eateries.index', ['feature' => $feature->name]) }}"
               class="bg-orange-100 text-orange-800 rounded px-2 py-0.5 text-xs hover:bg-orange-200">{{ $feature->name }}</a>
        @endforeach
    </div>
</article>