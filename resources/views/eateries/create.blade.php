@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Add Eatery</h1>

    <form method="POST" action="{{ route('eateries.store') }}" class="bg-white rounded shadow p-6">
        @csrf
        @include('eateries._form')

        <div class="mt-6 flex gap-2">
            <button type="submit" class="bg-orange-700 text-white rounded px-4 py-2">Save Eatery</button>
            <a href="{{ route('eateries.index') }}" class="border rounded px-4 py-2">Cancel</a>
        </div>
    </form>
@endsection