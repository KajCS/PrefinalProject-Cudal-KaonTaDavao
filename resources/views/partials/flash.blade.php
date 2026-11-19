@if (session('status'))
    <p class="bg-green-100 text-green-800 rounded px-4 py-2 mb-4">{{ session('status') }}</p>
@endif