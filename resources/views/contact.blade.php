@extends('layouts.public')

@section('content')
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -top-10 right-10 size-72 rounded-full bg-purple/15 blur-3xl"></div>
        <div class="mx-auto grid max-w-6xl gap-10 px-5 py-16 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <h1 class="text-5xl font-extrabold tracking-tight">Get in Touch</h1>
                <p class="mt-4 max-w-md leading-7 text-muted">We're here to help. Reach out to us for any queries, feedback or support.</p>

                <div class="mt-8 flex gap-3">
                    <a href="tel:+919325119325" class="grid size-11 place-items-center rounded-full bg-white text-purple shadow-sm transition hover:scale-105 hover:bg-purple hover:text-white" title="Call Us">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </a>
                    <a href="mailto:ho@mangalfinance.com" class="grid size-11 place-items-center rounded-full bg-white text-purple shadow-sm transition hover:scale-105 hover:bg-purple hover:text-white" title="Email Us">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </a>
                    <a href="https://wa.me/919325119325" target="_blank" rel="noopener" class="grid size-11 place-items-center rounded-full bg-white text-purple shadow-sm transition hover:scale-105 hover:bg-purple hover:text-white" title="Chat on WhatsApp">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    </a>
                </div>

                {{-- Quick Contact Card --}}
                <div class="mt-8 rounded-2xl border border-mist bg-white/80 p-6 shadow-sm backdrop-blur-sm">
                    <h2 class="text-base font-extrabold uppercase tracking-wider text-grape">Quick Contact</h2>

                    <div class="mt-5 space-y-5">
                        {{-- Address --}}
                        <div class="flex items-start gap-3.5">
                            <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-lilac text-purple">
                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 0 0 .723 0l.028-.015.071-.041a16.975 16.975 0 0 0 1.144-.742 19.58 19.58 0 0 0 2.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 0 0-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 0 0 2.682 2.282 16.975 16.975 0 0 0 1.145.742ZM12 13.5a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <div class="text-sm">
                                <span class="block text-xs font-bold uppercase tracking-wider text-grape">Address</span>
                                <p class="mt-1 leading-relaxed text-muted">
                                    1<sup>st</sup> floor, Vinayak tower, near medical square,<br>
                                    Untkhana, Nagpur, Maharashtra – 440009
                                </p>
                            </div>
                        </div>

                        <div class="border-t border-dashed border-mist"></div>

                        {{-- Phone --}}
                        <div class="flex items-start gap-3.5">
                            <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-lilac text-purple">
                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <div class="text-sm">
                                <span class="block text-xs font-bold uppercase tracking-wider text-grape">Phone</span>
                                <div class="mt-1 space-y-0.5 leading-relaxed text-muted">
                                    <div><a href="tel:07123102222" class="hover:text-purple transition">0712 – 3102222</a>,</div>
                                    <div>
                                        <a href="tel:+919325119325" class="hover:text-purple transition">+91-9325119325</a>,
                                        <a href="tel:+9107721954411" class="hover:text-purple transition">+91-077219 54411</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-dashed border-mist"></div>

                        {{-- Email --}}
                        <div class="flex items-start gap-3.5">
                            <span class="grid size-9 shrink-0 place-items-center rounded-xl bg-lilac text-purple">
                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                                    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                                </svg>
                            </span>
                            <div class="text-sm">
                                <span class="block text-xs font-bold uppercase tracking-wider text-grape">Email</span>
                                <div class="mt-1 space-y-0.5 leading-relaxed text-muted">
                                    <div><a href="mailto:ho@mangalfinance.com" class="hover:text-purple transition">ho@mangalfinance.com</a></div>
                                    <div><a href="mailto:mangalfinancenagpur@gmail.com" class="hover:text-purple transition">mangalfinancenagpur@gmail.com</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="mt-8 text-xl font-medium text-purple italic">We're just a message away!</p>
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
