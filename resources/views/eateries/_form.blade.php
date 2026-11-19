@php
    $checkedFeatures = $errors->any() ? old('features', []) : $selectedFeatures;
    $isOpen = $errors->any() ? old('is_open') : $eatery->is_open;
@endphp

@if ($errors->any())
    <div class="bg-red-100 text-red-800 rounded px-4 py-2 mb-4">
        <p class="font-semibold">Please fix the errors below.</p>
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <label class="flex flex-col gap-1">Name
        <input type="text" name="name" value="{{ old('name', $eatery->name) }}" class="border rounded px-3 py-2">
        @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>

    <label class="flex flex-col gap-1">District
        <select name="district_id" class="border rounded px-3 py-2">
            <option value="">Choose a district</option>
            @foreach ($districts as $district)
                <option value="{{ $district->id }}" @selected(old('district_id', $eatery->district_id) == $district->id)>{{ $district->name }}</option>
            @endforeach
        </select>
        @error('district_id') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>

    <label class="flex flex-col gap-1 md:col-span-2">Address
        <input type="text" name="address" value="{{ old('address', $eatery->address) }}" class="border rounded px-3 py-2">
        @error('address') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>

    <label class="flex flex-col gap-1">Price range
        <select name="price_range" class="border rounded px-3 py-2">
            <option value="">Choose a price range</option>
            @foreach (['budget' => 'Budget (₱)', 'mid' => 'Mid (₱₱)', 'splurge' => 'Splurge (₱₱₱)'] as $value => $label)
                <option value="{{ $value }}" @selected(old('price_range', $eatery->price_range) === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('price_range') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>

    <label class="flex flex-col gap-1">Specialty
        <input type="text" name="specialty" value="{{ old('specialty', $eatery->specialty) }}" class="border rounded px-3 py-2">
        @error('specialty') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>

    <div class="md:col-span-2">
        <label class="inline-flex items-center gap-2">
            <input type="checkbox" name="is_open" value="1" @checked($isOpen)>
            Open
        </label>
        @error('is_open') <span class="block text-red-600 text-sm">{{ $message }}</span> @enderror
    </div>

    <fieldset class="md:col-span-2">
        <legend class="mb-1">Features</legend>
        <div class="flex flex-wrap gap-4">
            @foreach ($features as $feature)
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="features[]" value="{{ $feature->id }}" @checked(in_array($feature->id, $checkedFeatures))>
                    {{ $feature->name }}
                </label>
            @endforeach
        </div>
        @error('features') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
        @error('features.*') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </fieldset>

    <label class="flex flex-col gap-1">Permit number
        <input type="text" name="permit_no" value="{{ old('permit_no', $eatery->permit?->permit_no) }}" placeholder="DVO-2026-0415" class="border rounded px-3 py-2">
        @error('permit_no') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>

    <label class="flex flex-col gap-1">Permit expiry date
        <input type="date" name="expires_on" value="{{ old('expires_on', $eatery->permit?->expires_on?->format('Y-m-d')) }}" class="border rounded px-3 py-2">
        @error('expires_on') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
    </label>
</div>