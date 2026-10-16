@extends('layouts.public')

@php
    $saved = $inspection->items->keyBy('item_key');
    $overall = (float) $inspection->overall_rating;
@endphp

@section('content')
    <span class="hidden text-emerald-600 text-amber-500 text-amber-400 text-red-600 opacity-25"></span>

    <style>
        @media print {
            header, nav, footer, .no-print, #download-pdf-btn, #bottom-download-btn {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                color: #111827 !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            section {
                max-width: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .rounded-2xl {
                border: 1px solid #e5e7eb !important;
                box-shadow: none !important;
                break-inside: avoid;
            }
            details {
                break-inside: avoid;
                margin-bottom: 1rem;
            }
            details[open] > summary {
                display: flex !important;
            }
            details[open] > *:not(summary) {
                display: block !important;
            }
        }
    </style>

    <section class="mx-auto max-w-3xl space-y-5 px-5 py-10">
        {{-- Top Action Bar with Download PDF and Print --}}
        <div class="flex flex-wrap items-center justify-between gap-3 pb-2 no-print">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-muted">Inspection Report · Car PDI</p>
                <h1 class="text-xl sm:text-2xl font-extrabold text-grape">{{ $inspection->brand }} {{ $inspection->model_name }}</h1>
            </div>
            <div class="flex items-center gap-2.5">
                <button type="button" id="download-pdf-btn" onclick="downloadReportPdf()" class="inline-flex items-center gap-2 rounded-xl bg-purple px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-purple/25 transition hover:bg-purple/90 active:scale-95 cursor-pointer">
                    <svg class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                    <span>Download PDF</span>
                </button>
                <button type="button" onclick="printReport()" class="inline-flex items-center gap-1.5 rounded-xl border border-mist bg-white px-3 py-2.5 text-sm font-semibold text-grape shadow-sm transition hover:border-purple active:scale-95 cursor-pointer" title="Print Report">
                    <svg class="size-4 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><path d="M6 14h12v8H6z"/></svg>
                    <span class="hidden sm:inline">Print</span>
                </button>
                <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" class="h-8 w-auto object-contain hidden sm:block ms-2">
            </div>
        </div>

        {{-- Printable Report Area --}}
        <div id="pdi-report-printable" class="space-y-5">
            {{-- Report Header with Logo --}}
            <div class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-mist bg-white p-5">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" class="h-10 w-auto object-contain">
                    <div class="border-l border-mist pl-3">
                        <div class="text-xs font-bold uppercase tracking-wider text-purple">Pre-Delivery Inspection Report</div>
                        <div class="text-base font-extrabold text-grape">Mangal Vehicle Finance Pvt. Ltd.</div>
                    </div>
                </div>
                <div class="text-right text-xs text-muted">
                    <div>PDI Ref: <span class="font-mono font-bold text-grape uppercase">{{ $inspection->getRouteKey() }}</span></div>
                    <div>Date: <span class="font-medium text-grape">{{ $inspection->inspected_on?->format('d M Y') ?? 'N/A' }}</span></div>
                </div>
            </div>

            {{-- Overall Rating Card --}}
            <div class="rounded-2xl border border-mist bg-white px-6 py-8 text-center relative overflow-hidden">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" class="h-12 w-auto object-contain">
                </div>
                <p class="text-5xl font-extrabold {{ \App\Models\Inspection::scoreClass($overall) }}">{{ number_format($overall, 1) }}/10</p>
                <p class="mt-2 text-sm text-muted">Overall Rating</p>
                @if ($inspection->status === 'completed')
                    <span class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-emerald-500 bg-emerald-50 px-3.5 py-1 text-xs font-bold tracking-wide text-emerald-700 uppercase">
                        <span class="size-1.5 rounded-full bg-emerald-600"></span>
                        COMPLETED
                    </span>
                @else
                    <span class="mt-4 inline-flex items-center gap-1.5 rounded-full border border-amber-500 bg-amber-50 px-3.5 py-1 text-xs font-bold tracking-wide text-amber-700 uppercase">
                        <span class="size-1.5 rounded-full bg-amber-500"></span>
                        PENDING
                    </span>
                @endif
            </div>

            {{-- Inspection Details Card --}}
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

            {{-- Photos Summary --}}
            <details class="group overflow-hidden rounded-2xl border border-mist bg-white" open>
                <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5">
                    <span class="text-lg font-bold">Photos ({{ $saved->count() }})</span>
                    <span class="grid size-9 shrink-0 place-items-center rounded-full bg-lilac text-purple no-print">
                        <svg class="size-5 transition duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
                    </span>
                </summary>
                <div class="grid grid-cols-3 gap-3 border-t border-mist p-6 sm:grid-cols-5">
                    @foreach ($saved as $item)
                        <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->label }}" class="aspect-square w-full rounded-xl object-cover">
                    @endforeach
                </div>
            </details>

            {{-- Checklist Sections --}}
            @foreach ($checklist as $section => $items)
                <details class="group overflow-hidden rounded-2xl border border-mist bg-white" open>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5">
                        <span>
                            <span class="block text-lg font-bold">{{ $section }}</span>
                            <span class="mt-1 block text-sm text-muted">{{ count($items) }} checks</span>
                        </span>
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-lilac text-purple no-print">
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
        </div>

        {{-- Bottom Download Button --}}
        <div class="mt-8 flex justify-center no-print" id="bottom-download-btn">
            <button type="button" onclick="downloadReportPdf()" class="inline-flex items-center gap-2.5 rounded-2xl bg-purple px-6 py-3.5 text-base font-bold text-white shadow-xl shadow-purple/30 transition hover:bg-purple/90 active:scale-95 cursor-pointer">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" /></svg>
                <span>Download Complete Inspection PDF</span>
            </button>
        </div>
    </section>

    {{-- Script for PDF Generation & Printing --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function prepareDetailsForPdf() {
            document.querySelectorAll('#pdi-report-printable details').forEach(el => el.setAttribute('open', ''));
        }

        function printReport() {
            prepareDetailsForPdf();
            window.print();
        }

        function downloadReportPdf() {
            prepareDetailsForPdf();

            const btn = document.getElementById('download-pdf-btn');
            const originalHtml = btn ? btn.innerHTML : '';
            if (btn) {
                btn.innerHTML = `<svg class="size-4 animate-spin inline mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10" stroke-opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/></svg> Generating PDF...`;
                btn.disabled = true;
            }

            const element = document.getElementById('pdi-report-printable');
            const filename = 'CarPDI-Report-{{ Str::slug(($inspection->vehicle_number ?: $inspection->brand.'-'.$inspection->model_name).'-'.$inspection->getRouteKey()) }}.pdf';

            if (typeof html2pdf !== 'undefined') {
                const opt = {
                    margin: [8, 8, 8, 8],
                    filename: filename,
                    image: { type: 'jpeg', quality: 0.98 },
                    html2canvas: { scale: 2, useCORS: true, logging: false },
                    jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                    pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                };

                html2pdf().set(opt).from(element).save().then(() => {
                    if (btn) {
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    }
                }).catch(() => {
                    window.print();
                    if (btn) {
                        btn.innerHTML = originalHtml;
                        btn.disabled = false;
                    }
                });
            } else {
                window.print();
                if (btn) {
                    btn.innerHTML = originalHtml;
                    btn.disabled = false;
                }
            }
        }
    </script>
@endsection
