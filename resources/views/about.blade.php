@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute top-10 right-0 size-80 rounded-full bg-purple/15 blur-3xl"></div>
        <div class="mx-auto grid max-w-6xl items-center gap-12 px-5 py-16 lg:grid-cols-2">
            <div>
                <h1 class="text-5xl font-extrabold tracking-tight">About Us</h1>
                <p class="mt-3 text-lg font-semibold text-purple">Driven by Trust. Built for You.</p>
                <p class="mt-5 max-w-xl leading-7 text-muted">
                    At CarPDI, we believe that buying a car is not just a purchase, it's an emotion. Our mission is to make the car delivery experience simple, transparent and worry-free with our detailed Pre Delivery Inspection (PDI) process.
                </p>
            </div>
            <div class="relative mx-auto w-full max-w-md">
                <img src="{{ asset('images/cars/detail.jpg') }}" alt="Car key and cabin detail" class="aspect-square w-full rounded-[2rem] object-cover shadow-xl shadow-purple/15">
                <p class="absolute -right-2 bottom-8 rounded-2xl bg-white px-4 py-3 text-sm font-bold text-purple shadow-lg">Your Trust<br>Drives Us</p>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-4 px-5 pb-12 md:grid-cols-3">
        @foreach ([
            ['Our Mission', 'To bring transparency and confidence to every car delivery.'],
            ['Our Vision', 'To be the most trusted car inspection platform in India.'],
            ['Our Values', 'Honesty | Accuracy | Customer First | Always'],
        ] as [$title, $text])
            <article class="rounded-3xl bg-white p-6 shadow-sm">
                <span class="grid size-12 place-items-center rounded-2xl bg-lilac text-purple">
                    <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="8" /><path d="M12 8v4l2.5 2" /></svg>
                </span>
                <h2 class="mt-4 text-lg font-bold">{{ $title }}</h2>
                <p class="mt-2 text-sm leading-6 text-muted">{{ $text }}</p>
            </article>
        @endforeach
    </section>

    <section class="mx-auto grid max-w-6xl items-center gap-8 px-5 pb-20 lg:grid-cols-2">
        <img src="{{ asset('images/cars/bmw.jpg') }}" alt="Car interior" class="aspect-[16/10] w-full rounded-[2rem] object-cover">
        <div>
            <h2 class="text-2xl font-extrabold">Why Choose Us?</h2>
            <ul class="mt-5 space-y-3 text-sm text-muted">
                @foreach (['Easy and seamless process', 'Photo & video proof for complete transparency', 'Secure and reliable platform', 'Dedicated customer support'] as $reason)
                    <li class="flex gap-3">
                        <span class="mt-0.5 grid size-5 shrink-0 place-items-center rounded-full bg-purple text-[10px] text-white">✓</span>
                        {{ $reason }}
                    </li>
                @endforeach
            </ul>
            <p class="mt-8 text-2xl font-medium text-purple italic">Better Inspection. Bigger Smiles.</p>
        </div>
    </section>
@endsection
