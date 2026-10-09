@extends('layouts.public')

@php
    $field = 'mt-2 w-full rounded-xl border border-mist bg-white px-4 py-3 text-sm outline-none focus:border-purple';
@endphp

@section('content')
    <span class="hidden sr-only text-emerald-600 text-amber-500 text-amber-400 text-red-600 opacity-25"></span>
    <section class="mx-auto max-w-3xl px-5 py-12">
        <h1 class="text-4xl font-extrabold">Car PDI</h1>
        <p class="mt-3 text-muted">Rate every check out of 10 and upload one photo for each. Exterior & Body needs 6 photos. Every other section needs 5.</p>

        <form method="POST" action="{{ route('pdi.store') }}" class="mt-8 space-y-6">
            @csrf
            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">The inspection was not saved.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="rounded-2xl border border-mist bg-white p-6">
                <h2 class="text-lg font-bold">Inspection Details</h2>
                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-medium">Inspector
                        <input name="inspector" value="{{ old('inspector') }}" required placeholder="Inspector name" class="{{ $field }}">
                        @error('inspector')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="text-sm font-medium">Date of PDI
                        <input name="inspected_on" type="date" value="{{ old('inspected_on') }}" required class="{{ $field }}">
                        @error('inspected_on')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="text-sm font-medium">Brand
                        <select name="brand" required class="{{ $field }}">
                            <option value="">Select Brand</option>
                            @foreach (['Maruti', 'Hyundai', 'Tata', 'Mahindra', 'Honda', 'Toyota', 'Kia', 'MG', 'Suzuki', 'BMW', 'Mercedes', 'DS Automobiles'] as $brand)
                                <option value="{{ $brand }}" @selected(old('brand') === $brand)>{{ $brand }}</option>
                            @endforeach
                        </select>
                        @error('brand')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="text-sm font-medium">Model
                        <input name="model_name" value="{{ old('model_name') }}" required placeholder="Model" class="{{ $field }}">
                        @error('model_name')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="text-sm font-medium">VIN
                        <input name="vin" value="{{ old('vin') }}" required placeholder="VIN" class="{{ $field }}">
                        @error('vin')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="text-sm font-medium">Location
                        <select name="location" required class="{{ $field }}">
                            <option value="">Select location</option>
                            @foreach (['Nagpur', 'Mumbai', 'Pune', 'Delhi', 'Bengaluru', 'Hyderabad'] as $city)
                                <option value="{{ $city }}" @selected(old('location') === $city)>{{ $city }}</option>
                            @endforeach
                        </select>
                        @error('location')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                </div>
            </div>

            @foreach ($checklist as $section => $items)
                @php
                    $sectionHasError = collect(array_keys($items))->contains(
                        fn (string $key): bool => $errors->has("items.{$key}.photo") || $errors->has("items.{$key}.score")
                    );
                @endphp
                <details class="group overflow-hidden rounded-2xl border border-mist bg-white" @if ($loop->first || $sectionHasError) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5">
                        <span>
                            <span class="block text-lg font-bold">{{ $section }}</span>
                            <span class="mt-1 block text-sm text-muted">{{ count($items) }} photos. Tap the stars, then add a photo for each check.</span>
                        </span>
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-lilac text-purple">
                            <svg class="size-5 transition duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
                        </span>
                    </summary>
                    <div class="divide-y divide-mist border-t border-mist px-6">
                        @foreach ($items as $key => $label)
                            @php $uploaded = $uploads[$key] ?? null; @endphp
                            <div class="flex gap-4 py-4">
                                <label class="relative flex size-20 shrink-0 cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-dashed border-purple/40 bg-lilac">
                                    <img data-preview alt="" class="absolute inset-0 size-full object-cover" @unless ($uploaded) hidden @endunless @if ($uploaded) src="{{ asset('storage/'.$uploaded) }}" @endif>
                                    <span data-placeholder class="text-xs font-semibold text-purple" @if ($uploaded) hidden @endif>Photo</span>
                                    <input data-photo data-item="{{ $key }}" type="file" accept="image/*" class="sr-only" @unless ($uploaded) required @endunless>
                                </label>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-grape/80">{{ $label }}</p>
                                    <div class="mt-2 flex flex-wrap gap-0.5" data-stars>
                                        @for ($score = 1; $score <= 10; $score++)
                                            <button type="button" data-star="{{ $score }}" class="text-mist" aria-label="{{ $score }} out of 10">
                                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.8 14.7 8.7l6.5.6-4.9 4.2 1.5 6.3L12 16.8 6.2 19.8l1.5-6.3L2.8 9.3l6.5-.6L12 2.8Z" /></svg>
                                            </button>
                                        @endfor
                                    </div>
                                    <p data-photo-status class="mt-1 text-xs text-muted">{{ $uploaded ? 'Photo ready' : '' }}</p>
                                    <input data-score type="hidden" name="items[{{ $key }}][score]" value="{{ old("items.{$key}.score") }}">
                                    @error("items.{$key}.photo")<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                                    @error("items.{$key}.score")<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endforeach

            @auth('web')
                <button type="submit" data-save class="rounded-full bg-purple px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple/25 disabled:opacity-60">Save inspection</button>
            @else
                <p class="text-sm text-muted">Log in on the website to save this inspection.</p>
                <a href="{{ route('login') }}" class="inline-flex rounded-full bg-purple px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple/25">Login to save</a>
            @endauth
        </form>
    </section>
    <script>
        let photoQueue = Promise.resolve();
        let photosUploading = 0;

        document.querySelectorAll('[data-photo]').forEach((input) => {
            input.addEventListener('change', () => {
                const frame = input.closest('label');
                const preview = frame.querySelector('[data-preview]');
                const placeholder = frame.querySelector('[data-placeholder]');
                const status = frame.parentElement.querySelector('[data-photo-status]');
                const file = input.files[0];
                const save = document.querySelector('[data-save]');

                if (! file || ! file.type.startsWith('image/')) {
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.hidden = false;
                placeholder.hidden = true;

                if (! save) {
                    return;
                }

                const body = new FormData();
                body.append('item', input.dataset.item);
                body.append('photo', file);

                photosUploading += 1;
                save.disabled = true;
                status.textContent = 'Uploading photo…';

                photoQueue = photoQueue.then(async () => {
                    try {
                        const response = await fetch(@json(route('pdi.photo')), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body,
                        });

                        if (! response.ok) {
                            status.textContent = 'Photo was not saved. Choose it again.';
                            return;
                        }

                        input.removeAttribute('required');
                        status.textContent = 'Photo ready';
                    } finally {
                        photosUploading -= 1;

                        if (photosUploading === 0) {
                            save.disabled = false;
                        }
                    }
                });
            });
        });

        document.querySelectorAll('[data-stars]').forEach((group) => {
            const scoreInput = group.parentElement.querySelector('[data-score]');

            const paint = (value) => {
                group.querySelectorAll('[data-star]').forEach((star) => {
                    const filled = Number(star.dataset.star) <= value;

                    star.classList.toggle('text-amber-400', filled);
                    star.classList.toggle('text-mist', ! filled);
                });
            };

            paint(Number(scoreInput.value || 0));

            group.querySelectorAll('[data-star]').forEach((star) => {
                star.addEventListener('click', () => {
                    scoreInput.value = star.dataset.star;
                    paint(Number(star.dataset.star));
                });
            });
        });
    </script>
@endsection
