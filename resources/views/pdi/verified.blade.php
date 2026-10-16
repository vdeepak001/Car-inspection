@extends('layouts.public', ['title' => 'Verified Car Inspections — Mangal Finance CarPDI'])

@section('content')
    <div class="mx-auto max-w-6xl px-5 py-8 sm:py-12">
        {{-- Breadcrumb & Back Link --}}
        <nav class="flex items-center gap-2 text-xs font-semibold text-muted mb-6">
            <a href="{{ route('home') }}" class="hover:text-purple transition">Home</a>
            <span>/</span>
            <span class="text-grape">Verified Cars</span>
        </nav>

        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 pb-8 border-b border-mist/80">
            <div>
                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-100 text-emerald-800 px-3 py-1 text-xs font-bold uppercase tracking-wider">
                    <span class="size-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Live Database Reports
                </span>
                <h1 class="mt-2 text-3xl sm:text-4xl font-extrabold text-grape tracking-tight">Verified Inspected Vehicles</h1>
                <p class="mt-2 text-sm sm:text-base text-muted max-w-2xl">
                    All cars listed below have completed multi-point PDI verification by Mangal Finance Group. Click any vehicle to open its full inspection report in a new page without login.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <span class="rounded-2xl border border-mist bg-white px-4 py-2.5 text-xs font-bold text-grape shadow-sm">
                    {{ $inspections->count() }} {{ Str::plural('Car', $inspections->count()) }} Available
                </span>
                <a href="{{ route('pdi') }}" class="inline-flex items-center gap-2 rounded-full bg-purple px-5 py-2.5 text-xs sm:text-sm font-bold text-white shadow-md shadow-purple/20 transition hover:bg-purple/90">
                    <span>+ Book New PDI</span>
                </a>
            </div>
        </div>

        {{-- Marketplace Cards Grid (Matching Screenshot 2) --}}
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($inspections as $inspection)
                @php
                    $carPhoto = $inspection->coverPhotoUrl();
                    $cleanPrice = $inspection->displayPrice();
                    $yearKm = $inspection->displayVariant();
                    $dateText = $inspection->displayDate();
                    $isElite = $inspection->isElite();
                @endphp

                <div class="group relative flex flex-col overflow-hidden rounded-2xl border border-mist bg-white shadow-sm transition duration-200 hover:shadow-xl hover:border-purple">
                    {{-- Card Image (Matching Screenshot 2) --}}
                    <div class="relative aspect-[4/3] w-full overflow-hidden bg-gray-100">
                        <a href="{{ route('pdi.show', $inspection) }}" target="_blank" rel="noopener noreferrer" class="block h-full w-full" title="Open {{ $inspection->brand }} {{ $inspection->model_name }} details in new page">
                            <img src="{{ $carPhoto }}" alt="{{ $inspection->brand }} {{ $inspection->model_name }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105" loading="lazy">
                        </a>

                        {{-- ELITE Badge --}}
                        @if ($isElite)
                            <span class="absolute top-3 left-3 bg-[#002f34]/90 text-white text-[10px] font-extrabold tracking-wider uppercase px-2 py-0.5 rounded shadow backdrop-blur-sm flex items-center gap-1">
                                <span>👑</span> ELITE
                            </span>
                        @endif

                        {{-- Heart Favorite Icon --}}
                        <button type="button" class="absolute top-3 right-3 grid size-8 place-items-center rounded-full bg-black/40 text-white backdrop-blur-sm transition hover:bg-black/60 cursor-pointer" title="Add to favorites">
                            <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
                        </button>

                        {{-- FEATURED Yellow Tag --}}
                        <span class="absolute bottom-3 left-3 bg-[#ffce32] text-gray-950 text-xs font-black px-2.5 py-0.5 rounded shadow-sm tracking-wider uppercase">
                            FEATURED
                        </span>

                        {{-- Overall Rating Pill --}}
                        <span class="absolute bottom-3 right-3 bg-white/95 backdrop-blur-sm text-purple font-extrabold text-xs px-2 py-0.5 rounded shadow-sm">
                            ★ {{ number_format((float) $inspection->overall_rating, 1) }}/10
                        </span>
                    </div>

                    {{-- Card Body (Matching Screenshot 2) --}}
                    <div class="relative flex flex-1 flex-col justify-between p-4 sm:p-5 bg-[linear-gradient(to_right,#f9fafb_1px,transparent_1px),linear-gradient(to_bottom,#f9fafb_1px,transparent_1px)] bg-[size:16px_16px]">
                        <div>
                            {{-- Price & Date Row --}}
                            <div class="flex items-baseline justify-between gap-2">
                                <span class="text-2xl font-black text-gray-900 tracking-tight">{{ $cleanPrice }}</span>
                                <span class="text-xs font-medium text-gray-400">{{ $dateText }}</span>
                            </div>

                            {{-- Year & Km Row --}}
                            <p class="mt-1 text-xs font-medium text-gray-500">
                                {{ $yearKm }}
                            </p>

                            {{-- Title Row --}}
                            <h3 class="mt-1 text-base font-bold text-gray-900 group-hover:text-purple transition truncate">
                                <a href="{{ route('pdi.show', $inspection) }}" target="_blank" rel="noopener noreferrer" title="View details in new tab">
                                    {{ $inspection->brand }} {{ $inspection->model_name }}
                                </a>
                            </h3>

                            @if ($inspection->vehicle_number)
                                <p class="text-xs font-mono font-semibold text-gray-400 uppercase mt-0.5">
                                    {{ $inspection->vehicle_number }}
                                </p>
                            @endif
                        </div>

                        {{-- Location & Action Buttons Row (Matching Screenshot 2) --}}
                        <div class="mt-4 pt-3 border-t border-mist/80 flex items-center justify-between">
                            <div class="flex items-center gap-1.5 text-xs text-gray-600 truncate max-w-[50%]">
                                <svg class="size-3.5 shrink-0 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                                <span class="truncate font-medium">{{ $inspection->location }}</span>
                            </div>

                            <div class="flex items-center gap-2">
                                {{-- Chat Icon (Circular button) --}}
                                <a href="https://wa.me/919922998822?text={{ urlencode('Hi, I am interested in '.$inspection->brand.' '.$inspection->model_name.' (PDI Report: '.route('pdi.show', $inspection).')') }}" target="_blank" rel="noopener noreferrer" class="grid size-8 place-items-center rounded-full bg-[#002f34] text-white transition hover:bg-emerald-600" title="Chat on WhatsApp (Opens in new tab)">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12c0 1.85.5 3.58 1.38 5.08L2 22l5.08-1.34C8.52 21.52 10.2 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.57 0-3.04-.45-4.29-1.22l-.31-.19-3.18.84.85-3.11-.2-.33A7.95 7.95 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/></svg>
                                </a>

                                {{-- Call Icon (Circular button) --}}
                                <a href="tel:+919922998822" class="grid size-8 place-items-center rounded-full bg-[#002f34] text-white transition hover:bg-purple" title="Call for details">
                                    <svg class="size-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 0 0-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/></svg>
                                </a>

                                {{-- View Details Link (opens report in new page without login) --}}
                                <a href="{{ route('pdi.show', $inspection) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-xl bg-purple px-3 py-1.5 text-xs font-bold text-white shadow-sm transition hover:bg-purple/90" title="View Inspection Details (Opens in new tab without login)">
                                    <span>Details</span>
                                    <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full rounded-2xl border border-dashed border-mist p-12 text-center bg-white">
                    <p class="text-base font-semibold text-grape">No completed vehicle inspections in the database yet.</p>
                    <p class="text-sm text-muted mt-1">Inspections marked as "Completed" by administrators will automatically appear here.</p>
                    <a href="{{ route('pdi') }}" class="mt-4 inline-flex items-center gap-2 rounded-full bg-purple px-5 py-2.5 text-sm font-semibold text-white">
                        Start Car PDI
                    </a>
                </div>
            @endforelse
        </div>
    </div>
@endsection
