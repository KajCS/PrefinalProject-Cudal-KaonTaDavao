<nav class="bg-orange-700 text-white">
    <div class="max-w-6xl mx-auto px-4 py-3 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <a href="{{ route('home') }}" class="font-bold text-lg">Kaon Ta! Davao – Cudal's Food Guide</a>
        <div class="flex flex-wrap items-center gap-4 text-sm">
            <a href="{{ route('home') }}" class="hover:underline">Home</a>
            <a href="{{ route('eateries.index') }}" class="hover:underline">Eateries</a>
            <a href="{{ route('districts.index') }}" class="hover:underline">Districts</a>
            <a href="{{ route('eateries.create') }}" class="hover:underline">Add Eatery</a>
        </div>
    </div>
</nav>