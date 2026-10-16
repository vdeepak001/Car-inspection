@extends('layouts.public')

@section('content')
    {{-- Hero Section --}}
    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute top-10 right-0 size-96 rounded-full bg-purple/15 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 left-10 size-72 rounded-full bg-purple/10 blur-3xl"></div>

        <div class="mx-auto max-w-6xl px-5 py-16 lg:py-20">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full bg-lilac px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-purple">
                        <span class="size-2 rounded-full bg-purple"></span>
                        Mangal Finance Group
                    </span>
                    <h1 class="mt-4 text-4xl sm:text-5xl font-extrabold tracking-tight text-grape">
                        Financing Happiness <br><span class="text-purple">Since 2005</span>
                    </h1>
                    <p class="mt-3 text-lg font-semibold text-purple">Pioneers for Vehicle Financing in Central India</p>

                    <div class="mt-5 space-y-3.5 text-sm leading-relaxed text-muted">
                        <p>
                            <strong class="text-grape font-semibold">Mangal Finance Group</strong> was established in 2005 as a joint flagship company by its promoters <strong class="text-grape font-semibold">Mr. Dilip Ranka</strong> and <strong class="text-grape font-semibold">Mr. Sachin Soni</strong>. The Corporate Office of Mangal Finance Group is proudly located in <strong class="text-grape font-semibold">Nagpur</strong>.
                        </p>
                        <p>
                            Over the years, the group has established itself as one of the pioneers for Vehicle Financing across Central India. <strong class="text-grape font-semibold">MANGAL VEHICLE FINANCE PVT LTD (MVFPL)</strong> is an <span class="rounded bg-lilac px-1.5 py-0.5 font-semibold text-purple">RBI registered NBFC</span> having a core, dedicated focus on vehicle financing.
                        </p>
                    </div>

                    {{-- Tagline Card --}}
                    <div class="mt-6 rounded-2xl border border-purple/30 bg-white/90 p-5 shadow-sm backdrop-blur-xs">
                        <div class="flex items-center gap-3">
                            <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-purple text-white font-bold text-lg">“</span>
                            <div>
                                <p class="text-base font-extrabold uppercase tracking-wide text-purple">FINANCING HAPPINESS</p>
                                <p class="text-xs text-muted mt-0.5">The official tagline of Mangal Finance Group — always keeping the happiness and success of our customers at heart.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hero Visual & Stats --}}
                <div class="relative">
                    <div class="relative mx-auto w-full max-w-lg overflow-hidden rounded-[2.5rem] bg-white p-3 shadow-2xl shadow-purple/15">
                        <img src="{{ asset('images/cars/detail.jpg') }}" alt="Mangal Finance Group Vehicle Financing" class="aspect-[4/3] w-full rounded-[2rem] object-cover">
                        <div class="p-4 sm:p-5">
                            <div class="flex items-center justify-between border-b border-mist pb-3">
                                <div>
                                    <span class="text-xs font-semibold text-muted">Headquarters</span>
                                    <p class="text-sm font-bold text-grape">Nagpur, Maharashtra</p>
                                </div>
                                <span class="rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-600 border border-emerald-200">RBI Registered NBFC</span>
                            </div>
                            <p class="mt-3 text-xs text-muted leading-relaxed">
                                Backed by <span class="font-bold text-grape">60+ years</span> of combined automotive promoter leadership and <span class="font-bold text-grape">15+ years</span> of proven vehicle financing track record.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4 Pillars Metric Cards --}}
            <div class="mt-14 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:border-purple/40">
                    <div class="text-3xl font-extrabold text-purple">15+ Years</div>
                    <div class="mt-1 text-sm font-bold text-grape">Vehicle Financing Legacy</div>
                    <p class="mt-2 text-xs text-muted leading-relaxed">Serving vehicle owners and businesses since 2005 with total integrity.</p>
                </div>
                <div class="rounded-2xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:border-purple/40">
                    <div class="text-3xl font-extrabold text-purple">60+ Years</div>
                    <div class="mt-1 text-sm font-bold text-grape">Promoters' Combined Experience</div>
                    <p class="mt-2 text-xs text-muted leading-relaxed">Extensive automotive industry expertise leading industry best practices.</p>
                </div>
                <div class="rounded-2xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:border-purple/40">
                    <div class="text-3xl font-extrabold text-purple">2,000+</div>
                    <div class="mt-1 text-sm font-bold text-grape">Vehicles Financed / Year</div>
                    <p class="mt-2 text-xs text-muted leading-relaxed">Consistently financing over 2,000 vehicles each year for the past 4 consecutive years.</p>
                </div>
                <div class="rounded-2xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:border-purple/40">
                    <div class="text-3xl font-extrabold text-purple">₹2,000+ Lakhs</div>
                    <div class="mt-1 text-sm font-bold text-grape">Annual Disbursement</div>
                    <p class="mt-2 text-xs text-muted leading-relaxed">Substantial annual capital deployment empowering mobility across Central India.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Products & Services --}}
    <section class="border-y border-mist bg-white/70 py-16 backdrop-blur-sm">
        <div class="mx-auto max-w-6xl px-5">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex rounded-full bg-lilac px-3 py-1 text-xs font-bold uppercase tracking-wider text-purple">Products & Services</span>
                <h2 class="mt-3 text-3xl font-extrabold text-grape">Vehicle Finance for Every Need</h2>
                <p class="mt-2 text-sm text-muted">Our products and services are primarily focused on vehicle finance across categories, covering both New and Used vehicles.</p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <div class="rounded-3xl border border-mist bg-white p-7 shadow-sm transition hover:border-purple/50">
                    <div class="flex items-center gap-4">
                        <span class="grid size-12 place-items-center rounded-2xl bg-lilac text-purple">
                            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18.5" cy="17.5" r="3.5"/><circle cx="5.5" cy="17.5" r="3.5"/><circle cx="15" cy="5" r="1"/><path d="M12 17.5V14l-3-3 4-3 2 3h2"/></svg>
                        </span>
                        <div>
                            <h3 class="text-xl font-bold text-grape">Two-Wheeler Finance</h3>
                            <span class="text-xs font-semibold text-purple">New Vehicles & Used Two-Wheelers</span>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-muted leading-relaxed">
                        Fast, affordable, and flexible financing solutions for two-wheelers. We assess vehicle condition, verify ownership, and provide customized loan options designed to put you on the road quickly.
                    </p>
                    <ul class="mt-4 space-y-2 text-xs text-grape/80">
                        <li class="flex items-center gap-2">✓ Competitive interest rates & easy documentation</li>
                        <li class="flex items-center gap-2">✓ Support for newly purchased and pre-owned bikes & scooters</li>
                    </ul>
                </div>

                <div class="rounded-3xl border border-mist bg-white p-7 shadow-sm transition hover:border-purple/50">
                    <div class="flex items-center gap-4">
                        <span class="grid size-12 place-items-center rounded-2xl bg-lilac text-purple">
                            <svg class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C2.1 10.7 2 10.8 2 11v5c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                        </span>
                        <div>
                            <h3 class="text-xl font-bold text-grape">Four-Wheeler Finance</h3>
                            <span class="text-xs font-semibold text-purple">New Vehicles & Used Cars</span>
                        </div>
                    </div>
                    <p class="mt-4 text-sm text-muted leading-relaxed">
                        Comprehensive loan assistance for hatchbacks, sedans, SUVs, and commercial vehicles. Backed by rigorous pre-delivery inspections (PDI) and transparent market value assessments.
                    </p>
                    <ul class="mt-4 space-y-2 text-xs text-grape/80">
                        <li class="flex items-center gap-2">✓ Financing up to 8–9 years of vehicle age</li>
                        <li class="flex items-center gap-2">✓ Thorough technical inspection by certified valuers</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Group Entities / Ecosystem (From Pinwheel Image) --}}
    <section class="py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex rounded-full bg-lilac px-3 py-1 text-xs font-bold uppercase tracking-wider text-purple">Group Companies</span>
                <h2 class="mt-3 text-3xl font-extrabold text-grape">The Mangal Finance Group Ecosystem</h2>
                <p class="mt-2 text-sm text-muted">A synergistic network of specialized firms spanning vehicle financing, used car dealing, trading, and allied real estate.</p>
            </div>

            <div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Mangal Finance --}}
                <div class="relative overflow-hidden rounded-3xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <span class="grid size-12 place-items-center rounded-2xl bg-emerald-100 text-emerald-700 font-extrabold text-sm">MF</span>
                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-bold text-emerald-700 border border-emerald-200">RBI Regd. NBFC</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-grape">MANGAL FINANCE</h3>
                    <p class="mt-2 text-xs font-semibold text-emerald-600 uppercase tracking-wide">Vehicle Financing</p>
                    <p class="mt-3 text-sm text-muted leading-relaxed">
                        Firm having core focus in Vehicle Financing. The flagship RBI-registered non-banking financial institution leading Central India's vehicle credit sector.
                    </p>
                </div>

                {{-- Deekay Cars --}}
                <div class="relative overflow-hidden rounded-3xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <span class="grid size-12 place-items-center rounded-2xl bg-blue-100 text-blue-700 font-extrabold text-sm">DC</span>
                        <span class="rounded-full bg-blue-50 px-2.5 py-1 text-[11px] font-bold text-blue-700 border border-blue-200">Automotive Dealing</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-grape">DEEKAY CARS</h3>
                    <p class="mt-2 text-xs font-semibold text-blue-600 uppercase tracking-wide">Used Car Dealing</p>
                    <p class="mt-3 text-sm text-muted leading-relaxed">
                        Firm having core focus on Used car dealing. Providing certified, high-quality pre-owned vehicles with complete inspection verification.
                    </p>
                </div>

                {{-- Deekay Motors --}}
                <div class="relative overflow-hidden rounded-3xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <span class="grid size-12 place-items-center rounded-2xl bg-sky-100 text-sky-700 font-extrabold text-sm">DM</span>
                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-[11px] font-bold text-sky-700 border border-sky-200">Automotive Trading</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-grape">DEEKAY MOTORS</h3>
                    <p class="mt-2 text-xs font-semibold text-sky-600 uppercase tracking-wide">Used Car Trading</p>
                    <p class="mt-3 text-sm text-muted leading-relaxed">
                        Firm having core focus on Used car trading. Specializing in commercial wholesale and retail trade of quality inspected passenger automobiles.
                    </p>
                </div>

                {{-- Mangal Developers --}}
                <div class="relative overflow-hidden rounded-3xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:-translate-y-1">
                    <div class="flex items-center justify-between">
                        <span class="grid size-12 place-items-center rounded-2xl bg-orange-100 text-orange-700 font-extrabold text-sm">MD</span>
                        <span class="rounded-full bg-orange-50 px-2.5 py-1 text-[11px] font-bold text-orange-700 border border-orange-200">Real Estate</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-grape">MANGAL DEVELOPERS</h3>
                    <p class="mt-2 text-xs font-semibold text-orange-600 uppercase tracking-wide">Real Estate & Allied Activities</p>
                    <p class="mt-3 text-sm text-muted leading-relaxed">
                        Firm having core focus in Real estate and allied activities. Creating trusted residential and commercial development projects.
                    </p>
                </div>

                {{-- Missri Vechfin Links --}}
                <div class="relative overflow-hidden rounded-3xl border border-mist bg-white p-6 shadow-sm transition hover:shadow-md hover:-translate-y-1 sm:col-span-2 lg:col-span-2">
                    <div class="flex items-center justify-between">
                        <span class="grid size-12 place-items-center rounded-2xl bg-slate-100 text-slate-700 font-extrabold text-sm">MV</span>
                        <span class="rounded-full bg-slate-50 px-2.5 py-1 text-[11px] font-bold text-slate-700 border border-slate-200">Financing Partner</span>
                    </div>
                    <h3 class="mt-4 text-xl font-extrabold text-grape">MISSRI VECHFIN LINKS</h3>
                    <p class="mt-2 text-xs font-semibold text-slate-600 uppercase tracking-wide">Vehicle Financing</p>
                    <p class="mt-3 text-sm text-muted leading-relaxed">
                        Firm having core focus in Vehicle Financing. Channeling vehicular credit and financial brokerage support to expand customer accessibility across the region.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Process Flow: 8 Stages (From Process Flow Image) --}}
    <section class="border-t border-mist bg-lilac/40 py-16">
        <div class="mx-auto max-w-6xl px-5">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex rounded-full bg-purple text-white px-3 py-1 text-xs font-bold uppercase tracking-wider">Operational Pipeline</span>
                <h2 class="mt-3 text-3xl font-extrabold text-grape">Our 8-Step Process Flow</h2>
                <p class="mt-2 text-sm text-muted">A systematic, verified, and transparent journey ensuring fast loan processing and absolute peace of mind.</p>
            </div>

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                {{-- Step 1 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/20">1</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-muted">Enquiry</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Enquiry & Vehicle Age Check</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Post receiving of enquiry from a customer, MVFPL primarily determines vehicle age. Financing is done upto age of 8–9 years.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-purple">Up to 8–9 Years Eligible</div>
                </div>

                {{-- Step 2 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/20">2</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-muted">Documents</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Customer & Guarantor KYC</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Next step is the documentation of customer & guarantor which includes the financial documents as well as the KYC documents.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-purple">KYC & Financial Records</div>
                </div>

                {{-- Step 3 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/20">3</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-muted">Verification</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Data Investigation & Eligibility</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Post documentation, MVFPL conducts necessary investigations of the customer for the genuineness of data and customer eligibility.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-purple">Eligibility Verification</div>
                </div>

                {{-- Step 4 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/20">4</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-muted">Valuation</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Financing Amount Finalization</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Next stage is to finalize the financing amount. The amount financed is derived as a percentage of the present market value of the vehicle.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-purple">Market Value Percentage</div>
                </div>

                {{-- Step 5 --}}
                <div class="relative rounded-3xl border-2 border-purple bg-white p-6 shadow-md shadow-purple/10 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/30">5</span>
                            <span class="rounded-full bg-lilac px-2 py-0.5 text-[10px] font-bold uppercase tracking-wider text-purple">Core Step</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Technical PDI & Agreement</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Detailed technical inspection of the vehicle is conducted by valuer. Agreement is done with the customer.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-bold text-purple">Comprehensive Vehicle Inspection</div>
                </div>

                {{-- Step 6 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/20">6</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-muted">Operations</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Operational Protocols</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Post approval of agreement, necessary operational protocols and administrative compliances are completed.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-purple">Compliance & File Approval</div>
                </div>

                {{-- Step 7 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-purple text-white font-extrabold text-base shadow-md shadow-purple/20">7</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-muted">Hypothecation</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Hypothecation Charge</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            The final stage before disbursement of the loan, is creation of hypothecation charge on the vehicle financed.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-purple">Vehicle Charge Creation</div>
                </div>

                {{-- Step 8 --}}
                <div class="relative rounded-3xl border border-mist bg-white p-6 shadow-sm flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between">
                            <span class="grid size-11 place-items-center rounded-2xl bg-emerald-600 text-white font-extrabold text-base shadow-md shadow-emerald-500/20">8</span>
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600">Disbursement</span>
                        </div>
                        <h4 class="mt-4 font-bold text-grape">Disbursement & Follow-up</h4>
                        <p class="mt-2 text-xs leading-relaxed text-muted">
                            Subsequently the loan amount gets disbursed in the customer’s account and regular follow-ups are done with customers.
                        </p>
                    </div>
                    <div class="mt-4 pt-3 border-t border-mist text-[11px] font-medium text-emerald-600">Account Credit & Ongoing Support</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action --}}
    <section class="mx-auto max-w-6xl px-5 py-20 text-center">
        <div class="rounded-3xl border border-purple/30 bg-white p-8 sm:p-12 shadow-xl shadow-purple/10">
            <h2 class="text-3xl font-extrabold text-grape">Ready to Experience "Financing Happiness"?</h2>
            <p class="mt-3 text-sm text-muted max-w-xl mx-auto">
                Whether you're looking for vehicle financing or need a detailed Pre Delivery Inspection (PDI) for your next vehicle, our team is here to support you every step of the way.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('pdi') }}" class="rounded-full bg-purple px-7 py-3.5 text-sm font-semibold text-white shadow-lg shadow-purple/25 transition hover:bg-purple/90">
                    Start Vehicle PDI
                </a>
                <a href="{{ route('contact') }}" class="rounded-full border border-purple px-7 py-3.5 text-sm font-semibold text-purple transition hover:bg-lilac">
                    Contact Our Nagpur Office
                </a>
            </div>
        </div>
    </section>
@endsection
