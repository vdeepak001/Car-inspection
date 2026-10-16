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
            <dl class="mt-4 grid gap-3 sm:grid-cols-2 text-sm">
                <div class="flex justify-between gap-4"><dt class="text-muted">Inspector</dt><dd class="font-medium">{{ $inspection->inspector }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">Date of PDI</dt><dd class="font-medium">{{ $inspection->inspected_on?->format('d M Y') }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">Brand & Model</dt><dd class="font-medium">{{ $inspection->brand }} {{ $inspection->model_name }}</dd></div>
                @if ($inspection->vehicle_variant)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Variant</dt><dd class="font-medium">{{ $inspection->vehicle_variant }}</dd></div>
                @endif
                @if ($inspection->vehicle_number)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Vehicle No.</dt><dd class="font-medium font-mono uppercase">{{ $inspection->vehicle_number }}</dd></div>
                @endif
                <div class="flex justify-between gap-4"><dt class="text-muted">Chassis / VIN</dt><dd class="font-medium font-mono uppercase">{{ $inspection->chassis_number ?: $inspection->vin }}</dd></div>
                <div class="flex justify-between gap-4"><dt class="text-muted">Location</dt><dd class="font-medium">{{ $inspection->location }}</dd></div>
                @if ($inspection->rto_location)
                    <div class="flex justify-between gap-4"><dt class="text-muted">RTO Location</dt><dd class="font-medium">{{ $inspection->rto_location }}</dd></div>
                @endif
                @if ($inspection->rc_status)
                    <div class="flex justify-between gap-4"><dt class="text-muted">RC Status</dt><dd class="font-medium">{{ $inspection->rc_status }}</dd></div>
                @endif
                @if ($inspection->rc_valid_until)
                    <div class="flex justify-between gap-4"><dt class="text-muted">RC Valid Date</dt><dd class="font-medium">{{ $inspection->rc_valid_until->format('d M Y') }}</dd></div>
                @endif
                @if ($inspection->insurance_type)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Insurance</dt><dd class="font-medium">{{ $inspection->insurance_type }}</dd></div>
                @endif
                @if ($inspection->insurance_valid_until)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Insurance Valid Date</dt><dd class="font-medium">{{ $inspection->insurance_valid_until->format('d M Y') }}</dd></div>
                @endif
                @if ($inspection->customer_name)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Customer Name</dt><dd class="font-medium">{{ $inspection->customer_name }}</dd></div>
                @endif
                @if ($inspection->approx_expense)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Approx Expense</dt><dd class="font-medium">{{ $inspection->approx_expense }}</dd></div>
                @endif
                @if ($inspection->market_value)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Market Value</dt><dd class="font-medium">{{ $inspection->market_value }}</dd></div>
                @endif
                @if ($inspection->sale_price)
                    <div class="flex justify-between gap-4"><dt class="text-muted">Sale Price</dt><dd class="font-medium">{{ $inspection->sale_price }}</dd></div>
                @endif
                @if ($inspection->file_number)
                    <div class="flex justify-between gap-4"><dt class="text-muted">File No.</dt><dd class="font-medium">{{ $inspection->file_number }}</dd></div>
                @endif
                @if ($inspection->remark)
                    <div class="sm:col-span-2 flex flex-col gap-1 border-t border-mist/60 pt-2"><dt class="text-muted">Remark</dt><dd class="font-medium whitespace-pre-line">{{ $inspection->remark }}</dd></div>
                @endif
            </dl>

            @if ($inspection->rc_front_photo || $inspection->rc_back_photo || $inspection->insurance_photo)
                <div class="mt-6 border-t border-mist pt-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-purple">Uploaded Documents</h3>
                    <div class="mt-3 grid gap-3 sm:grid-cols-3 text-xs">
                        @if ($inspection->rc_front_photo)
                            <a href="{{ asset('storage/'.$inspection->rc_front_photo) }}" target="_blank" rel="noopener" class="flex items-center gap-2 rounded-xl border border-mist bg-lilac/30 p-2.5 font-medium text-grape hover:border-purple">
                                <svg class="size-4 shrink-0 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                                <span class="truncate">RC Front Document</span>
                            </a>
                        @endif
                        @if ($inspection->rc_back_photo)
                            <a href="{{ asset('storage/'.$inspection->rc_back_photo) }}" target="_blank" rel="noopener" class="flex items-center gap-2 rounded-xl border border-mist bg-lilac/30 p-2.5 font-medium text-grape hover:border-purple">
                                <svg class="size-4 shrink-0 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                                <span class="truncate">RC Back Document</span>
                            </a>
                        @endif
                        @if ($inspection->insurance_photo)
                            <a href="{{ asset('storage/'.$inspection->insurance_photo) }}" target="_blank" rel="noopener" class="flex items-center gap-2 rounded-xl border border-mist bg-lilac/30 p-2.5 font-medium text-grape hover:border-purple">
                                <svg class="size-4 shrink-0 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <span class="truncate">Insurance Document</span>
                            </a>
                        @endif
                    </div>
                </div>
            @endif
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
