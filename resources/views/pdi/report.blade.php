@extends('layouts.public')

@php
    $saved = $inspection->items->keyBy('item_key');
    $overall = (float) $inspection->overall_rating;
@endphp

@section('content')
    <span class="hidden text-emerald-600 text-amber-500 text-amber-400 text-red-600 opacity-25"></span>
    <section class="mx-auto max-w-3xl space-y-5 px-5 py-12">
        <p class="text-center text-sm text-muted">Inspection Report · Car PDI</p>

        <div class="rounded-2xl border border-mist bg-white px-6 py-8 text-center">
            <p class="text-5xl font-extrabold {{ \App\Models\Inspection::scoreClass($overall) }}">{{ number_format($overall, 1) }}/10</p>
            <p class="mt-2 text-sm text-muted">Overall Rating</p>
            <span class="mt-4 inline-flex rounded-md border border-emerald-500 px-3 py-1 text-xs font-bold tracking-wide text-emerald-600">COMPLETED</span>
        </div>

        <div class="rounded-2xl border border-mist bg-white p-6">
            <h2 class="text-lg font-bold">Inspection Details</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-muted">Inspector</dt><dd class="font-medium">{{ $inspection->inspector }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">Date</dt><dd class="font-medium">{{ $inspection->inspected_on?->format('d M Y') }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">Brand</dt><dd class="font-medium">{{ $inspection->brand }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">Model</dt><dd class="font-medium">{{ $inspection->model_name }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">VIN</dt><dd class="font-medium">{{ $inspection->vin }}</dd></div>
            </dl>
        </div>

        <details class="group overflow-hidden rounded-2xl border border-mist bg-white">
            <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5">
                <span class="text-lg font-bold">Photos ({{ $saved->count() }})</span>
                <span class="grid size-9 shrink-0 place-items-center rounded-full bg-lilac text-purple">
                    <svg class="size-5 transition duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
                </span>
            </summary>
            <div class="grid grid-cols-3 gap-3 border-t border-mist p-6 sm:grid-cols-5">
                @foreach ($saved as $item)
                    <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->label }}" class="aspect-square w-full rounded-xl object-cover">
                @endforeach
            </div>
        </details>

        @foreach ($checklist as $section => $items)
            <details class="group overflow-hidden rounded-2xl border border-mist bg-white" @if ($loop->first) open @endif>
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5">
                    <span>
                        <span class="block text-lg font-bold">{{ $section }}</span>
                        <span class="mt-1 block text-sm text-muted">{{ count($items) }} checks</span>
                    </span>
                    <span class="grid size-9 shrink-0 place-items-center rounded-full bg-lilac text-purple">
                        <svg class="size-5 transition duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
                    </span>
                </summary>
                <ul class="divide-y divide-mist border-t border-mist px-6">
                    @foreach ($items as $key => $label)
                        @php $item = $saved->get($key); @endphp
                        <li class="flex items-center gap-4 py-4 text-sm">
                            @if ($item?->photo)
                                <img src="{{ asset('storage/'.$item->photo) }}" alt="" class="size-16 shrink-0 rounded-xl object-cover">
                            @endif
                            <span class="min-w-0 flex-1 text-grape/80">{{ $label }}</span>
                            <span class="flex shrink-0 gap-0.5 {{ \App\Models\Inspection::scoreClass($item->score) }}" aria-label="{{ $item->score }} out of 10">
                                @for ($star = 1; $star <= 10; $star++)
                                    <svg class="size-3.5 {{ $star <= $item->score ? '' : 'opacity-25' }}" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.8 14.7 8.7l6.5.6-4.9 4.2 1.5 6.3L12 16.8 6.2 19.8l1.5-6.3L2.8 9.3l6.5-.6L12 2.8Z" /></svg>
                                @endfor
                            </span>
                        </li>
                    @endforeach
                </ul>
            </details>
        @endforeach
    </section>
@endsection
