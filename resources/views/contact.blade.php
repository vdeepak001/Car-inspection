@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -top-10 right-10 size-72 rounded-full bg-purple/15 blur-3xl"></div>
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-16 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <h1 class="text-5xl font-extrabold tracking-tight">Get in Touch</h1>
                <p class="mt-4 max-w-md leading-7 text-muted">We're here to help. Reach out to us for any queries, feedback or support.</p>

                <div class="mt-8 flex gap-3">
                    @foreach (['Call', 'Email', 'Chat'] as $label)
                        <span class="grid size-11 place-items-center rounded-full bg-white text-purple shadow-sm" title="{{ $label }}">
                            <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><circle cx="12" cy="12" r="8" /></svg>
                        </span>
                    @endforeach
                </div>

                <h2 class="mt-10 text-lg font-bold">Contact Information</h2>
                <ul class="mt-4 space-y-4 text-sm text-muted">
                    <li><span class="block font-semibold text-grape">+91 98765 43210</span> Mon – Sat, 9:00 AM – 7:00 PM</li>
                    <li><span class="block font-semibold text-grape">support@carpdi.com</span> We reply within 24 hours</li>
                    <li><span class="block font-semibold text-grape">Nagpur, Maharashtra</span> India – 440001</li>
                </ul>

                <p class="mt-10 text-xl font-medium text-purple italic">We're just a message away!</p>
            </div>

            <form method="POST" action="{{ route('contact.store') }}" class="rounded-[2rem] bg-white p-6 shadow-xl shadow-purple/10 sm:p-8">
                @csrf
                <h2 class="text-2xl font-extrabold">Send Us a Message</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <label class="block text-sm font-medium">
                        Name
                        <input name="name" value="{{ old('name') }}" required placeholder="Your Name" class="mt-2 w-full rounded-xl border border-mist bg-lilac/40 px-4 py-3 outline-none focus:border-purple">
                        @error('name')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-medium">
                        Email
                        <input name="email" type="email" value="{{ old('email') }}" required placeholder="Your Email" class="mt-2 w-full rounded-xl border border-mist bg-lilac/40 px-4 py-3 outline-none focus:border-purple">
                        @error('email')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-medium sm:col-span-2">
                        Phone Number
                        <input name="phone" value="{{ old('phone') }}" placeholder="Your Phone Number" class="mt-2 w-full rounded-xl border border-mist bg-lilac/40 px-4 py-3 outline-none focus:border-purple">
                        @error('phone')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                    <label class="block text-sm font-medium sm:col-span-2">
                        Message
                        <textarea name="message" rows="5" required placeholder="Your Message Here" class="mt-2 w-full rounded-xl border border-mist bg-lilac/40 px-4 py-3 outline-none focus:border-purple">{{ old('message') }}</textarea>
                        @error('message')<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                    </label>
                </div>
                <button type="submit" class="mt-6 inline-flex items-center gap-2 rounded-full bg-purple px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple/25">
                    Send Message <span aria-hidden="true">→</span>
                </button>
            </form>
        </div>
    </section>
@endsection
