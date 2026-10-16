<footer class="mt-20 border-t border-mist/80 bg-white text-grape">
    {{-- Trust & Key Numbers Bar --}}
    <div class="border-b border-mist/60 bg-lilac/40">
        <div class="mx-auto max-w-6xl px-5 py-8">
            <div class="grid grid-cols-2 gap-6 sm:grid-cols-4">
                <div class="flex items-center gap-3.5">
                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-purple/10 text-purple font-extrabold text-xl">
                        🏦
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-muted">RBI Registered</p>
                        <p class="text-sm font-extrabold text-grape">Certified NBFC</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5">
                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-purple/10 text-purple font-extrabold text-xl">
                        🚗
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-muted">Annual Volume</p>
                        <p class="text-sm font-extrabold text-grape">2,000+ Vehicles</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5">
                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-purple/10 text-purple font-extrabold text-xl">
                        💰
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-muted">Disbursements</p>
                        <p class="text-sm font-extrabold text-grape">₹ 2,000+ Lakhs/Yr</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5">
                    <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-purple/10 text-purple font-extrabold text-xl">
                        ⭐
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-muted">Experience</p>
                        <p class="text-sm font-extrabold text-grape">15+ Yrs (60+ Yrs Exp)</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Footer Navigation --}}
    <div class="mx-auto max-w-6xl px-5 py-14">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-12">
            {{-- Company Brand Column --}}
            <div class="lg:col-span-5">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance Group" class="h-10 w-auto object-contain">
                    <span class="border-l border-mist pl-3 font-extrabold text-grape text-lg">CarPDI</span>
                </a>

                <p class="mt-4 text-xs font-black tracking-wider uppercase text-purple">
                    “Financing Happiness”
                </p>

                <p class="mt-2 text-sm leading-relaxed text-muted pr-4">
                    Mangal Finance Group was established in 2005 by promoters <strong>Mr. Dilip Ranka</strong> and <strong>Mr. Sachin Soni</strong> with Corporate Office in Nagpur. As a pioneer in Central India, <strong>MANGAL VEHICLE FINANCE PVT LTD</strong> is an RBI registered NBFC with 60+ years combined automotive promoter experience.
                </p>

                {{-- Direct Contact Chips --}}
                <div class="mt-6 flex flex-wrap items-center gap-2">
                    <a href="https://wa.me/919922998822" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full border border-mist bg-white px-3.5 py-1.5 text-xs font-semibold text-grape transition hover:border-emerald-500 hover:text-emerald-700 hover:shadow-sm">
                        <svg class="size-3.5 text-emerald-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12c0 1.85.5 3.58 1.38 5.08L2 22l5.08-1.34C8.52 21.52 10.2 22 12 22c5.52 0 10-4.48 10-10S17.52 2 12 2zm0 18c-1.57 0-3.04-.45-4.29-1.22l-.31-.19-3.18.84.85-3.11-.2-.33A7.95 7.95 0 0 1 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8-3.59 8-8 8z"/></svg>
                        <span>WhatsApp: +91 99229 98822</span>
                    </a>
                    <a href="tel:+919922998822" class="inline-flex items-center gap-2 rounded-full border border-mist bg-white px-3.5 py-1.5 text-xs font-semibold text-grape transition hover:border-purple hover:text-purple hover:shadow-sm">
                        <svg class="size-3.5 text-purple" viewBox="0 0 24 24" fill="currentColor"><path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 0 0-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/></svg>
                        <span>Call Us Today</span>
                    </a>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="lg:col-span-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-grape">Explore</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-muted">
                    <li><a href="{{ route('home') }}" class="transition hover:text-purple">Home</a></li>
                    <li><a href="{{ route('pdi.verified') }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-purple inline-flex items-center gap-1 font-semibold text-purple"><span>Verified Cars</span><span class="text-xs">↗</span></a></li>
                    <li><a href="{{ route('about') }}" class="transition hover:text-purple">About Us</a></li>
                    <li><a href="{{ route('pdi') }}" class="transition hover:text-purple">Book Car PDI</a></li>
                    <li><a href="{{ route('contact') }}" class="transition hover:text-purple">Contact Us</a></li>
                    @guest('web')
                        <li><a href="{{ route('login') }}" class="transition hover:text-purple">Account Sign In</a></li>
                    @else
                        <li><a href="{{ route('pdi') }}" class="transition hover:text-purple">My Account</a></li>
                    @endguest
                    <li><a href="{{ route('admin.login') }}" class="transition hover:text-purple text-xs text-muted/70">Admin Portal</a></li>
                </ul>
            </div>

            {{-- Inspection Standards --}}
            <div class="lg:col-span-2">
                <h3 class="text-xs font-bold uppercase tracking-wider text-grape">PDI Checks</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-muted">
                    <li>Exterior & Paint Inspection</li>
                    <li>Engine Bay & Fluid Levels</li>
                    <li>Tyres Tread & Alloy Rims</li>
                    <li>Air Conditioning & Climate</li>
                    <li>Infotainment & Reverse Camera</li>
                    <li>RC & Document Verification</li>
                    <li>Official PDF PDI Certificate</li>
                </ul>
            </div>

            {{-- Corporate Office Details --}}
            <div class="lg:col-span-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-grape">Corporate Office</h3>
                <div class="mt-4 space-y-3 text-sm text-muted">
                    <p class="flex items-start gap-2.5">
                        <svg class="size-4 shrink-0 mt-0.5 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                        <span>Mangal Finance Group, Corporate Office, Nagpur, Maharashtra, India - 440010</span>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="size-4 shrink-0 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
                        <a href="tel:+919922998822" class="hover:text-purple transition">+91 99229 98822</a>
                    </p>
                    <p class="flex items-center gap-2.5">
                        <svg class="size-4 shrink-0 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                        <span>contact@mangalfinance.com</span>
                    </p>
                    <p class="flex items-center gap-2.5 text-xs text-muted/80">
                        <svg class="size-4 shrink-0 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        <span>Mon – Sat: 9:30 AM – 7:00 PM</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-mist/70 bg-gray-50/70 py-6 text-xs text-muted">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-5 sm:flex-row">
            <p>© 2005–{{ date('Y') }} Mangal Vehicle Finance Pvt. Ltd. All rights reserved. Registered NBFC with RBI.</p>
            <div class="flex items-center gap-4">
                <span class="text-purple font-semibold">“Financing Happiness”</span>
                <span>•</span>
                <span>Nagpur, Central India</span>
            </div>
        </div>
    </div>
</footer>
