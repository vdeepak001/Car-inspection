@extends('layouts.public')

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden pt-6 pb-16 sm:py-20">
        {{-- Ambient Gradient Glows --}}
        <div class="pointer-events-none absolute -top-32 right-0 size-[32rem] rounded-full bg-purple/15 blur-3xl"></div>
        <div class="pointer-events-none absolute top-48 -left-24 size-80 rounded-full bg-purple/10 blur-3xl"></div>

        <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 lg:grid-cols-12 lg:gap-8">
            <div class="lg:col-span-7">
                {{-- Trust Tag --}}
                <div class="inline-flex items-center gap-2 rounded-full border border-purple/20 bg-white/80 px-4 py-1.5 text-xs font-bold text-purple shadow-sm backdrop-blur-sm">
                    <span class="flex size-2 rounded-full bg-purple animate-pulse"></span>
                    <span>Mangal Finance Group • RBI Registered NBFC</span>
                </div>

                <h1 class="mt-5 text-4xl leading-[1.08] font-black tracking-tight text-grape sm:text-6xl sm:leading-[1.06]">
                    Your New Car,<br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple via-indigo-600 to-purple">
                        Our Absolute Priority
                    </span>
                </h1>

                <p class="mt-6 max-w-xl text-base leading-relaxed text-muted sm:text-lg">
                    We make your car delivery experience joyful and transparent with a comprehensive 25+ point Pre-Delivery Inspection (PDI) backed by 15+ years of vehicle financing expertise in Central India.
                </p>

                {{-- Action Buttons --}}
                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <a href="{{ route('pdi') }}" class="inline-flex items-center gap-2.5 rounded-full bg-purple px-7 py-3.5 text-sm font-bold text-white shadow-xl shadow-purple/25 transition duration-200 hover:bg-purple/90 hover:scale-[1.02] active:scale-95">
                        <span>Book Car PDI</span>
                        <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
                    </a>

                    <a href="{{ route('pdi.verified') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-mist bg-white px-6 py-3.5 text-sm font-bold text-grape shadow-sm transition duration-200 hover:border-purple hover:text-purple hover:shadow-md">
                        <span>View Verified Cars</span>
                        <svg class="size-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                    </a>
                </div>

                {{-- Micro Trust Indicators --}}
                <div class="mt-8 flex flex-wrap items-center gap-6 border-t border-mist/80 pt-6 text-xs font-semibold text-muted">
                    <div class="flex items-center gap-2">
                        <svg class="size-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        <span>Zero Hidden Defects</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="size-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        <span>Full Digital PDF Report</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="size-4 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                        <span>60+ Yrs Promoter Experience</span>
                    </div>
                </div>
            </div>

            {{-- Hero Visual with Floating Pill Badges --}}
            <div class="relative lg:col-span-5">
                <div class="absolute -inset-4 rounded-[3rem] bg-gradient-to-tr from-purple/30 to-indigo-500/20 blur-2xl"></div>

                <div class="relative overflow-hidden rounded-[2.5rem] border border-white/80 bg-white shadow-2xl shadow-purple/20">
                    <img src="{{ asset('images/cars/hero.jpg') }}" alt="Verified car inspection by Mangal Finance" class="aspect-[5/3] w-full object-cover">

                    {{-- Overlay Floating Badge 1 (Top Right) --}}
                    <div class="absolute top-4 right-4 rounded-2xl bg-white/95 px-3.5 py-2 shadow-lg backdrop-blur-md flex items-center gap-2 text-xs font-bold text-grape">
                        <span class="grid size-6 place-items-center rounded-full bg-emerald-500 text-white text-[11px]">✓</span>
                        <span>Certified PDI</span>
                    </div>

                    {{-- Overlay Floating Badge 2 (Bottom Left) --}}
                    <div class="absolute bottom-4 left-4 rounded-2xl bg-grape/90 px-4 py-2.5 shadow-xl backdrop-blur-md flex items-center gap-3 text-white">
                        <span class="text-xl">🛡️</span>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-gray-300">Standard Checklist</p>
                            <p class="text-xs font-extrabold text-white">25+ Inspection Points</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Banner --}}
    <section class="mx-auto max-w-6xl px-5 pb-16">
        <div class="rounded-3xl border border-mist/80 bg-white p-6 shadow-sm sm:p-8">
            <div class="grid grid-cols-2 gap-6 lg:grid-cols-4">
                <div class="border-b border-mist/80 pb-4 sm:border-b-0 sm:border-r sm:pb-0 sm:pr-4">
                    <p class="text-3xl sm:text-4xl font-black text-purple">2,000+</p>
                    <p class="mt-1 text-xs sm:text-sm font-semibold text-grape">Vehicles Financed / Year</p>
                    <p class="text-xs text-muted">Consistent 4-year track record</p>
                </div>

                <div class="border-b border-mist/80 pb-4 sm:border-b-0 sm:border-r sm:pb-0 sm:pr-4">
                    <p class="text-3xl sm:text-4xl font-black text-purple">₹2,000+ L</p>
                    <p class="mt-1 text-xs sm:text-sm font-semibold text-grape">Disbursed Annually</p>
                    <p class="text-xs text-muted">Core focus on vehicle finance</p>
                </div>

                <div class="border-b border-mist/80 pb-4 sm:border-b-0 sm:border-r sm:pb-0 sm:pr-4">
                    <p class="text-3xl sm:text-4xl font-black text-purple">15+ Yrs</p>
                    <p class="mt-1 text-xs sm:text-sm font-semibold text-grape">Business Experience</p>
                    <p class="text-xs text-muted">Serving Central India since 2005</p>
                </div>

                <div>
                    <p class="text-3xl sm:text-4xl font-black text-purple">60+ Yrs</p>
                    <p class="mt-1 text-xs sm:text-sm font-semibold text-grape">Promoters' Experience</p>
                    <p class="text-xs text-muted">Automotive industry leaders</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Value Pillars Section --}}
    <section class="mx-auto max-w-6xl px-5 pb-16">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-purple">Why Choose CarPDI</span>
            <h2 class="mt-2 text-3xl font-extrabold text-grape sm:text-4xl">Inspected with Precision & Integrity</h2>
            <p class="mt-2 text-sm text-muted">Every vehicle is evaluated across paint, engine, fluids, tyres, and documentation by trained automotive evaluators.</p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['🔍', 'Detailed Inspection', 'Thorough 25+ point check covering all body panels, chassis, electronics, and underbody condition.'],
                ['📸', 'High-Res Evidence', 'Clear photo evidence recorded for paint, tyres, glass, and engine components for full transparency.'],
                ['📊', 'Instant Scoring', 'Objective star rating and aggregate score generated automatically with zero bias.'],
                ['📄', 'Downloadable PDF', 'Official Mangal Finance PDI Certificate ready to download and keep in your vehicle records.'],
            ] as [$emoji, $title, $text])
                <article class="group relative rounded-3xl border border-mist/80 bg-white p-6 shadow-sm transition duration-300 hover:shadow-xl hover:-translate-y-1 hover:border-purple/40">
                    <span class="grid size-14 place-items-center rounded-2xl bg-lilac text-2xl group-hover:scale-110 transition duration-300">
                        {{ $emoji }}
                    </span>
                    <h3 class="mt-5 text-lg font-bold text-grape">{{ $title }}</h3>
                    <p class="mt-2 text-sm leading-relaxed text-muted">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </section>

    {{-- How It Works Section with 5 Points --}}
    <section class="mx-auto max-w-6xl px-5 pb-20">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple">Seamless Process</span>
                <h2 class="mt-1 text-3xl font-extrabold text-grape sm:text-4xl">How It Works</h2>
                <p class="mt-1 text-sm text-muted">A clear, 5-step journey from booking to verified inspection reports.</p>
            </div>
            <a href="{{ route('pdi.verified') }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 rounded-full border border-purple/30 bg-purple/5 px-4 py-2 text-xs font-bold text-purple transition hover:bg-purple hover:text-white">
                <span>Browse Verified Cars</span>
                <svg class="size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
            </a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ([
                ['1', 'Book PDI', 'Schedule your professional car inspection before delivery.'],
                ['2', 'Inspect & Capture', 'Trained inspectors verify mechanicals and capture high-res photos.'],
                ['3', 'Review Scores', 'Examine section-by-section scores and documentation status.'],
                ['4', 'Drive with Confidence', 'Complete peace of mind knowing your vehicle is verified.'],
                ['5', 'View Details', 'Check verified car reports from database without login in new page.'],
            ] as [$step, $title, $text])
                @if ($step === '5')
                    <a href="{{ route('pdi.verified') }}" target="_blank" rel="noopener noreferrer" class="group relative block rounded-2xl border-2 border-purple bg-gradient-to-b from-white to-purple/5 p-5 shadow-md shadow-purple/10 transition duration-300 hover:shadow-xl hover:scale-[1.02]" title="Open verified car details in new page">
                        <div class="flex items-center justify-between">
                            <span class="grid size-10 place-items-center rounded-full bg-purple text-sm font-extrabold text-white shadow-md shadow-purple/30 transition group-hover:scale-110">{{ $step }}</span>
                            <span class="inline-flex items-center gap-1 rounded-full bg-purple/10 px-2.5 py-0.5 text-[11px] font-bold text-purple">
                                <span>New Page</span>
                                <svg class="size-2.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25"/></svg>
                            </span>
                        </div>
                        <h3 class="mt-4 font-extrabold text-grape group-hover:text-purple transition text-base">
                            {{ $title }}
                        </h3>
                        <p class="mt-1.5 text-xs leading-relaxed text-muted">{{ $text }}</p>
                    </a>
                @else
                    <article class="rounded-2xl border border-mist/80 bg-white p-5 shadow-sm transition hover:border-purple/30">
                        <span class="grid size-10 place-items-center rounded-full bg-lilac text-sm font-bold text-purple">{{ $step }}</span>
                        <h3 class="mt-4 font-bold text-grape text-base">{{ $title }}</h3>
                        <p class="mt-1.5 text-xs leading-relaxed text-muted">{{ $text }}</p>
                    </article>
                @endif
            @endforeach
        </div>
    </section>

    {{-- Pre-Footer Action Banner --}}
    <section class="mx-auto max-w-6xl px-5 pb-16">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-grape via-purple/90 to-grape p-8 sm:p-12 text-white shadow-2xl shadow-purple/20">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="max-w-xl">
                    <span class="text-xs font-bold uppercase tracking-wider text-lilac/80">Mangal Finance CarPDI</span>
                    <h2 class="mt-2 text-2xl sm:text-3xl font-extrabold text-white">Financing Happiness Across Central India</h2>
                    <p class="mt-2 text-sm text-lilac/90 leading-relaxed">
                        Never accept a car without verifying its pre-delivery inspection. Protect your investment with official certifications from Mangal Finance Group.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('pdi') }}" class="rounded-full bg-white px-6 py-3.5 text-sm font-bold text-grape shadow-lg transition hover:bg-lilac hover:scale-105 active:scale-95">
                        Start Inspection Now
                    </a>
                    <a href="{{ route('pdi.verified') }}" target="_blank" rel="noopener noreferrer" class="rounded-full border border-white/30 bg-white/10 px-6 py-3.5 text-sm font-bold text-white backdrop-blur-sm transition hover:bg-white/20">
                        Browse Cars ↗
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
