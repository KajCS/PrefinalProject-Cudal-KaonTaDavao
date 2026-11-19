@props(['value'])

@php
    $stars = (int) round($value);
@endphp

<span class="text-yellow-500" aria-label="{{ $value }} out of 5">{{ str_repeat('★', $stars) }}{{ str_repeat('☆', 5 - $stars) }}</span>