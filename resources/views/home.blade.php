@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -top-24 right-0 size-[28rem] rounded-full bg-purple/15 blur-3xl"></div>
        <div class="pointer-events-none absolute top-40 -left-20 size-72 rounded-full bg-purple/10 blur-3xl"></div>
        <div class="mx-auto grid max-w-6xl items-center gap-10 px-5 py-16 lg:grid-cols-2 lg:py-20">
            <div>
                <h1 class="text-5xl leading-[1.05] font-extrabold tracking-tight sm:text-6xl">
                    Your New Car<br>Our Priority
                </h1>
                <p class="mt-6 max-w-md text-base leading-7 text-muted">
                    We make your car delivery experience special with a detailed and transparent Pre Delivery Inspection (PDI) process.
                </p>
                <a href="{{ route('pdi') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-purple px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple/30 transition hover:bg-purple/90">
                    Get Started
                    <span aria-hidden="true">→</span>
                </a>
            </div>
            <div class="relative">
                <div class="absolute inset-6 rounded-[2.5rem] bg-purple/20 blur-2xl"></div>
                <img src="{{ asset('images/cars/hero.jpg') }}" alt="White car ready for inspection" class="relative aspect-[5/3] w-full rounded-[2rem] object-cover shadow-2xl shadow-purple/20">
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-4 px-5 pb-16 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Detailed Inspection', 'Check every detail before delivery.'],
            ['Photo & Video Upload', 'Capture the real condition.'],
            ['Track & Manage', 'Access anytime, anywhere.'],
            ['Peace of Mind', 'Because your trust matters.'],
        ] as [$title, $text])
            <article class="rounded-3xl bg-white p-6 shadow-sm shadow-purple/5">
                <span class="grid size-12 place-items-center rounded-2xl bg-lilac text-purple">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" d="M12 3.5 14.2 8l4.8.5-3.6 3.3.9 4.7L12 14.8 7.7 16.5l.9-4.7L5 8.5 9.8 8 12 3.5Z" /></svg>
                </span>
                <h2 class="mt-4 text-base font-bold">{{ $title }}</h2>
                <p class="mt-2 text-sm leading-6 text-muted">{{ $text }}</p>
            </article>
        @endforeach
    </section>

    <section class="mx-auto max-w-6xl px-5 pb-20">
        <h2 class="text-3xl font-extrabold">How It Works</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['1', 'Book PDI', 'Schedule your car inspection.'],
                ['2', 'Inspect & Capture', 'Add photos & videos of your car.'],
                ['3', 'Review', 'Check the report online.'],
                ['4', 'Drive with Confidence', 'Your car is ready.'],
            ] as [$step, $title, $text])
                <article>
                    <span class="grid size-10 place-items-center rounded-full bg-purple text-sm font-bold text-white">{{ $step }}</span>
                    <h3 class="mt-4 font-bold">{{ $title }}</h3>
                    <p class="mt-1 text-sm text-muted">{{ $text }}</p>
                </article>
            @endforeach
        </div>
    </section>
@endsection
