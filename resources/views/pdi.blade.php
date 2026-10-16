@extends('layouts.public')

@php
    $field = 'mt-2 w-full rounded-xl border border-mist bg-white px-4 py-3 text-sm outline-none focus:border-purple';
@endphp

@section('content')
    <span class="hidden sr-only text-emerald-600 text-amber-500 text-amber-400 text-red-600 opacity-25"></span>
    <style>
        .pdi-card {
            background: #ffffff;
            border: 1px solid #e6def8;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(36, 27, 58, 0.04);
            margin-bottom: 1.5rem;
        }
        .pdi-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.25rem 1.5rem;
        }
        @media (min-width: 768px) {
            .pdi-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .pdi-col-span-2 {
                grid-column: span 2 / span 2;
            }
        }
        .pdi-field {
            margin-top: 0.5rem;
            width: 100%;
            box-sizing: border-box;
            border-radius: 0.75rem;
            border: 1px solid #e6def8;
            background-color: #ffffff;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .pdi-field:focus {
            border-color: #6d4bd8;
            box-shadow: 0 0 0 3px rgba(109, 75, 216, 0.15);
        }
        .pdi-custom-box {
            margin-top: 0.625rem;
            border-radius: 0.75rem;
            border: 1px solid rgba(109, 75, 216, 0.25);
            background-color: rgba(244, 239, 255, 0.6);
            padding: 0.75rem;
            box-sizing: border-box;
        }
    </style>
    <section class="mx-auto max-w-5xl px-4 sm:px-6 py-10">
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-grape tracking-tight">Car PDI Inspection</h1>
                <p class="mt-2 text-sm sm:text-base text-muted max-w-3xl">Complete vehicle details, verify registration and insurance documentation, and rate each checklist check with photos.</p>
            </div>
            <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" class="h-12 sm:h-14 w-auto object-contain self-start sm:self-center shrink-0">
        </div>

        <form method="POST" action="{{ route('pdi.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">The inspection was not saved.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @php
                $dropdownCategories = ['inspector', 'brand', 'model', 'location', 'rc_status', 'insurance_type'];
                $dropdownOptions = [];
                foreach ($dropdownCategories as $cat) {
                    $dropdownOptions[$cat] = ($options[$cat] ?? null) ?: \App\Models\InspectionOption::forCategory($cat);
                }

                $selectedInspector = old('inspector');
                $isCustomInspector = filled($selectedInspector) && ! $dropdownOptions['inspector']->contains($selectedInspector) && $selectedInspector !== '__other__';

                $selectedBrand = old('brand');
                $isCustomBrand = filled($selectedBrand) && ! $dropdownOptions['brand']->contains($selectedBrand) && $selectedBrand !== '__other__';

                $selectedModel = old('model_name');
                $isCustomModel = filled($selectedModel) && ! $dropdownOptions['model']->contains($selectedModel) && $selectedModel !== '__other__';

                $selectedLocation = old('location');
                $isCustomLocation = filled($selectedLocation) && ! $dropdownOptions['location']->contains($selectedLocation) && $selectedLocation !== '__other__';

                $selectedRcStatus = old('rc_status');
                $isCustomRcStatus = filled($selectedRcStatus) && ! $dropdownOptions['rc_status']->contains($selectedRcStatus) && $selectedRcStatus !== '__other__';

                $selectedInsurance = old('insurance_type');
                $isCustomInsurance = filled($selectedInsurance) && ! $dropdownOptions['insurance_type']->contains($selectedInsurance) && $selectedInsurance !== '__other__';

                $isRcAvailable = str_contains(strtolower((string) $selectedRcStatus), 'available')
                    || str_contains(strtolower((string) $selectedRcStatus), 'avilable')
                    || str_contains(strtolower((string) $selectedRcStatus), 'abailble')
                    || str_contains(strtolower((string) $selectedRcStatus), 'drc')
                    || str_contains(strtolower((string) $selectedRcStatus), 'plain');

                $hasInsurance = filled($selectedInsurance)
                    && ! str_contains(strtolower((string) $selectedInsurance), 'expired')
                    && ! str_contains(strtolower((string) $selectedInsurance), 'none')
                    && $selectedInsurance !== '__other__';
            @endphp

            {{-- Card 1: Inspection Overview --}}
            <div class="pdi-card">
                <div class="flex items-center justify-between border-b border-mist pb-3 mb-5">
                    <div class="flex items-center gap-2.5">
                        <span class="grid size-8 place-items-center rounded-lg bg-lilac text-purple">
                            <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </span>
                        <div>
                            <h2 class="text-base font-bold text-grape">1. Inspection Logistics</h2>
                            <p class="text-xs text-muted">Inspector, inspection date, and location details</p>
                        </div>
                    </div>
                    <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" class="h-7 w-auto object-contain hidden sm:block">
                </div>

                <div class="pdi-grid">
                    {{-- Inspector Name --}}
                    <div>
                        <div class="flex items-center justify-between text-sm font-medium text-grape">
                            <label for="inspector-select">Inspector Name</label>
                            <button type="button" data-custom-toggle="inspector" class="text-xs font-semibold text-purple transition hover:underline">+ Add other</button>
                        </div>
                        <select id="inspector-select" name="inspector" required class="pdi-field" data-custom-select="inspector">
                            <option value="">Select Inspector</option>
                            @foreach ($dropdownOptions['inspector'] as $name)
                                <option value="{{ $name }}" @selected($selectedInspector === $name)>{{ $name }}</option>
                            @endforeach
                            @if ($isCustomInspector)
                                <option value="{{ $selectedInspector }}" selected>{{ $selectedInspector }}</option>
                            @endif
                            <option value="__other__" @selected($selectedInspector === '__other__')>+ Other (Add new inspector)</option>
                        </select>
                        <div data-custom-box="inspector" class="pdi-custom-box @unless ($selectedInspector === '__other__') hidden @endunless">
                            <div class="text-xs font-semibold text-purple mb-1.5">Add custom inspector:</div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" data-custom-input="inspector" name="inspector_custom" value="{{ old('inspector_custom', $isCustomInspector ? $selectedInspector : '') }}" placeholder="Type inspector name" class="flex-1 min-w-0 rounded-lg border border-mist bg-white px-3 py-2 text-sm outline-none focus:border-purple">
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-custom-add="inspector" class="rounded-lg bg-purple px-3.5 py-2 text-xs font-bold text-white transition hover:bg-purple/90 whitespace-nowrap">Add & Select</button>
                                    <button type="button" data-custom-cancel="inspector" class="rounded-lg border border-mist bg-white px-2.5 py-2 text-xs font-medium text-muted hover:text-grape whitespace-nowrap">Cancel</button>
                                </div>
                            </div>
                        </div>
                        @error('inspector')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Date of PDI --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Date of PDI
                            <input name="inspected_on" type="date" value="{{ old('inspected_on', date('Y-m-d')) }}" required class="pdi-field">
                        </label>
                        @error('inspected_on')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Location --}}
                    <div>
                        <div class="flex items-center justify-between text-sm font-medium text-grape">
                            <label for="location-select">Location</label>
                            <button type="button" data-custom-toggle="location" class="text-xs font-semibold text-purple transition hover:underline">+ Add other</button>
                        </div>
                        <select id="location-select" name="location" required class="pdi-field" data-custom-select="location">
                            <option value="">Select location</option>
                            @foreach ($dropdownOptions['location'] as $city)
                                <option value="{{ $city }}" @selected($selectedLocation === $city)>{{ $city }}</option>
                            @endforeach
                            @if ($isCustomLocation)
                                <option value="{{ $selectedLocation }}" selected>{{ $selectedLocation }}</option>
                            @endif
                            <option value="__other__" @selected($selectedLocation === '__other__')>+ Other (Add new location)</option>
                        </select>
                        <div data-custom-box="location" class="pdi-custom-box @unless ($selectedLocation === '__other__') hidden @endunless">
                            <div class="text-xs font-semibold text-purple mb-1.5">Add custom location:</div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" data-custom-input="location" name="location_custom" value="{{ old('location_custom', $isCustomLocation ? $selectedLocation : '') }}" placeholder="Type location name" class="flex-1 min-w-0 rounded-lg border border-mist bg-white px-3 py-2 text-sm outline-none focus:border-purple">
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-custom-add="location" class="rounded-lg bg-purple px-3.5 py-2 text-xs font-bold text-white transition hover:bg-purple/90 whitespace-nowrap">Add & Select</button>
                                    <button type="button" data-custom-cancel="location" class="rounded-lg border border-mist bg-white px-2.5 py-2 text-xs font-medium text-muted hover:text-grape whitespace-nowrap">Cancel</button>
                                </div>
                            </div>
                        </div>
                        @error('location')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- RTO Location --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">RTO Location
                            <input name="rto_location" value="{{ old('rto_location') }}" placeholder="e.g. MH-31 Nagpur" class="pdi-field">
                        </label>
                        @error('rto_location')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Card 2: Vehicle Details & Identification --}}
            <div class="pdi-card">
                <div class="flex items-center gap-2.5 border-b border-mist pb-3 mb-5">
                    <span class="grid size-8 place-items-center rounded-lg bg-lilac text-purple">
                        <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-.6 0-1.1.4-1.4.9l-1.5 2.8C2.1 10.7 2 10.8 2 11v5c0 .6.4 1 1 1h2"/><circle cx="7" cy="17" r="2"/><circle cx="17" cy="17" r="2"/></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-bold text-grape">2. Vehicle Information & Identification</h2>
                        <p class="text-xs text-muted">Brand, model, variant, registration number, and chassis VIN</p>
                    </div>
                </div>

                <div class="pdi-grid">
                    {{-- Brand --}}
                    <div>
                        <div class="flex items-center justify-between text-sm font-medium text-grape">
                            <label for="brand-select">Brand</label>
                            <button type="button" data-custom-toggle="brand" class="text-xs font-semibold text-purple transition hover:underline">+ Add other</button>
                        </div>
                        <select id="brand-select" name="brand" required class="pdi-field" data-custom-select="brand">
                            <option value="">Select Brand</option>
                            @foreach ($dropdownOptions['brand'] as $brand)
                                <option value="{{ $brand }}" @selected($selectedBrand === $brand)>{{ $brand }}</option>
                            @endforeach
                            @if ($isCustomBrand)
                                <option value="{{ $selectedBrand }}" selected>{{ $selectedBrand }}</option>
                            @endif
                            <option value="__other__" @selected($selectedBrand === '__other__')>+ Other (Add new brand)</option>
                        </select>
                        <div data-custom-box="brand" class="pdi-custom-box @unless ($selectedBrand === '__other__') hidden @endunless">
                            <div class="text-xs font-semibold text-purple mb-1.5">Add custom brand:</div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" data-custom-input="brand" name="brand_custom" value="{{ old('brand_custom', $isCustomBrand ? $selectedBrand : '') }}" placeholder="Type brand name" class="flex-1 min-w-0 rounded-lg border border-mist bg-white px-3 py-2 text-sm outline-none focus:border-purple">
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-custom-add="brand" class="rounded-lg bg-purple px-3.5 py-2 text-xs font-bold text-white transition hover:bg-purple/90 whitespace-nowrap">Add & Select</button>
                                    <button type="button" data-custom-cancel="brand" class="rounded-lg border border-mist bg-white px-2.5 py-2 text-xs font-medium text-muted hover:text-grape whitespace-nowrap">Cancel</button>
                                </div>
                            </div>
                        </div>
                        @error('brand')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Model --}}
                    <div>
                        <div class="flex items-center justify-between text-sm font-medium text-grape">
                            <label for="model-select">Model</label>
                            <button type="button" data-custom-toggle="model" class="text-xs font-semibold text-purple transition hover:underline">+ Add other</button>
                        </div>
                        <select id="model-select" name="model_name" required class="pdi-field" data-custom-select="model">
                            <option value="">Select Model</option>
                            @foreach ($dropdownOptions['model'] as $model)
                                <option value="{{ $model }}" @selected($selectedModel === $model)>{{ $model }}</option>
                            @endforeach
                            @if ($isCustomModel)
                                <option value="{{ $selectedModel }}" selected>{{ $selectedModel }}</option>
                            @endif
                            <option value="__other__" @selected($selectedModel === '__other__')>+ Other (Add new model)</option>
                        </select>
                        <div data-custom-box="model" class="pdi-custom-box @unless ($selectedModel === '__other__') hidden @endunless">
                            <div class="text-xs font-semibold text-purple mb-1.5">Add custom model:</div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" data-custom-input="model" name="model_name_custom" value="{{ old('model_name_custom', $isCustomModel ? $selectedModel : '') }}" placeholder="Type model name" class="flex-1 min-w-0 rounded-lg border border-mist bg-white px-3 py-2 text-sm outline-none focus:border-purple">
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-custom-add="model" class="rounded-lg bg-purple px-3.5 py-2 text-xs font-bold text-white transition hover:bg-purple/90 whitespace-nowrap">Add & Select</button>
                                    <button type="button" data-custom-cancel="model" class="rounded-lg border border-mist bg-white px-2.5 py-2 text-xs font-medium text-muted hover:text-grape whitespace-nowrap">Cancel</button>
                                </div>
                            </div>
                        </div>
                        @error('model_name')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Vehicle Variant --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Vehicle Variant
                            <input name="vehicle_variant" value="{{ old('vehicle_variant') }}" placeholder="e.g. VXI, ZXI+, GT Line" class="pdi-field">
                        </label>
                        @error('vehicle_variant')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Vehicle Number --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Vehicle Number
                            <input name="vehicle_number" value="{{ old('vehicle_number') }}" placeholder="e.g. MH 31 AB 1234" class="pdi-field uppercase font-mono tracking-wider">
                        </label>
                        @error('vehicle_number')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Chassis Number (Full width) --}}
                    <div class="pdi-col-span-2 rounded-xl border border-mist bg-lilac/20 p-4">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 text-sm font-medium text-grape">
                            <label for="chassis-input" class="font-bold flex items-center gap-1.5">
                                <svg class="size-4 text-purple" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                Chassis Number (VIN)
                            </label>
                            <span data-chassis-counter class="text-xs font-mono font-semibold text-muted bg-white px-2.5 py-1 rounded-full border border-mist self-start sm:self-auto">0/17 characters</span>
                        </div>
                        <input id="chassis-input" name="chassis_number" value="{{ old('chassis_number', old('vin')) }}" maxlength="17" placeholder="Unique 17-character alphanumeric code" class="pdi-field uppercase font-mono tracking-widest text-base font-semibold">
                        <p class="mt-1.5 text-xs text-muted">Must be a unique 17-character alphanumeric vehicle identification code.</p>
                        @error('chassis_number')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                        @error('vin')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Card 3: RC Status & Documentation --}}
            <div class="pdi-card">
                <div class="flex items-center gap-2.5 border-b border-mist pb-3 mb-5">
                    <span class="grid size-8 place-items-center rounded-lg bg-lilac text-purple">
                        <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-bold text-grape">3. Vehicle RC (Registration Certificate)</h2>
                        <p class="text-xs text-muted">RC status, validity date, and front/back document uploads</p>
                    </div>
                </div>

                <div class="pdi-grid">
                    {{-- RC Status --}}
                    <div>
                        <div class="flex items-center justify-between text-sm font-medium text-grape">
                            <label for="rc-status-select">Vehicle RC Status</label>
                            <button type="button" data-custom-toggle="rc_status" class="text-xs font-semibold text-purple transition hover:underline">+ Add other</button>
                        </div>
                        <select id="rc-status-select" name="rc_status" class="pdi-field" data-custom-select="rc_status">
                            <option value="">Select RC Status</option>
                            @foreach ($dropdownOptions['rc_status'] as $status)
                                <option value="{{ $status }}" @selected($selectedRcStatus === $status)>{{ $status }}</option>
                            @endforeach
                            @if ($isCustomRcStatus)
                                <option value="{{ $selectedRcStatus }}" selected>{{ $selectedRcStatus }}</option>
                            @endif
                            <option value="__other__" @selected($selectedRcStatus === '__other__')>+ Other (Add new RC status)</option>
                        </select>
                        <div data-custom-box="rc_status" class="pdi-custom-box @unless ($selectedRcStatus === '__other__') hidden @endunless">
                            <div class="text-xs font-semibold text-purple mb-1.5">Add custom RC status:</div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" data-custom-input="rc_status" name="rc_status_custom" value="{{ old('rc_status_custom', $isCustomRcStatus ? $selectedRcStatus : '') }}" placeholder="Type RC status" class="flex-1 min-w-0 rounded-lg border border-mist bg-white px-3 py-2 text-sm outline-none focus:border-purple">
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-custom-add="rc_status" class="rounded-lg bg-purple px-3.5 py-2 text-xs font-bold text-white transition hover:bg-purple/90 whitespace-nowrap">Add & Select</button>
                                    <button type="button" data-custom-cancel="rc_status" class="rounded-lg border border-mist bg-white px-2.5 py-2 text-xs font-medium text-muted hover:text-grape whitespace-nowrap">Cancel</button>
                                </div>
                            </div>
                        </div>
                        @error('rc_status')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- RC Valid Date --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">RC Valid Date
                            <input name="rc_valid_until" type="date" value="{{ old('rc_valid_until') }}" class="pdi-field">
                        </label>
                        @error('rc_valid_until')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Conditional RC Upload Box (Full width) --}}
                    <div data-rc-upload-box class="pdi-col-span-2 @unless ($isRcAvailable) hidden @endunless rounded-xl border border-purple/30 bg-lilac/30 p-4 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold text-purple uppercase tracking-wider">
                            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M12 18v-6"/><path d="m9 15 3-3 3 3"/></svg>
                            Upload RC Documentation (Images or PDF)
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-lg border border-white bg-white/80 p-3 shadow-xs">
                                <label class="block text-xs font-bold text-grape">RC Front Image / PDF
                                    <input type="file" name="rc_front" accept="image/*,application/pdf" class="mt-2 block w-full text-xs text-muted file:mr-2.5 file:rounded-lg file:border-0 file:bg-purple file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-purple/90">
                                </label>
                                @error('rc_front')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                            </div>
                            <div class="rounded-lg border border-white bg-white/80 p-3 shadow-xs">
                                <label class="block text-xs font-bold text-grape">RC Back Image / PDF
                                    <input type="file" name="rc_back" accept="image/*,application/pdf" class="mt-2 block w-full text-xs text-muted file:mr-2.5 file:rounded-lg file:border-0 file:bg-purple file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-purple/90">
                                </label>
                                @error('rc_back')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card 4: Insurance Details --}}
            <div class="pdi-card">
                <div class="flex items-center gap-2.5 border-b border-mist pb-3 mb-5">
                    <span class="grid size-8 place-items-center rounded-lg bg-lilac text-purple">
                        <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-bold text-grape">4. Vehicle Insurance Policy</h2>
                        <p class="text-xs text-muted">Policy type, expiration date, and insurance document upload</p>
                    </div>
                </div>

                <div class="pdi-grid">
                    {{-- Insurance Type --}}
                    <div>
                        <div class="flex items-center justify-between text-sm font-medium text-grape">
                            <label for="insurance-select">Insurance Type</label>
                            <button type="button" data-custom-toggle="insurance_type" class="text-xs font-semibold text-purple transition hover:underline">+ Add other</button>
                        </div>
                        <select id="insurance-select" name="insurance_type" class="pdi-field" data-custom-select="insurance_type">
                            <option value="">Select Insurance Type</option>
                            @foreach ($dropdownOptions['insurance_type'] as $ins)
                                <option value="{{ $ins }}" @selected($selectedInsurance === $ins)>{{ $ins }}</option>
                            @endforeach
                            @if ($isCustomInsurance)
                                <option value="{{ $selectedInsurance }}" selected>{{ $selectedInsurance }}</option>
                            @endif
                            <option value="__other__" @selected($selectedInsurance === '__other__')>+ Other (Add new insurance type)</option>
                        </select>
                        <div data-custom-box="insurance_type" class="pdi-custom-box @unless ($selectedInsurance === '__other__') hidden @endunless">
                            <div class="text-xs font-semibold text-purple mb-1.5">Add custom insurance type:</div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <input type="text" data-custom-input="insurance_type" name="insurance_type_custom" value="{{ old('insurance_type_custom', $isCustomInsurance ? $selectedInsurance : '') }}" placeholder="Type insurance type" class="flex-1 min-w-0 rounded-lg border border-mist bg-white px-3 py-2 text-sm outline-none focus:border-purple">
                                <div class="flex items-center gap-2 shrink-0">
                                    <button type="button" data-custom-add="insurance_type" class="rounded-lg bg-purple px-3.5 py-2 text-xs font-bold text-white transition hover:bg-purple/90 whitespace-nowrap">Add & Select</button>
                                    <button type="button" data-custom-cancel="insurance_type" class="rounded-lg border border-mist bg-white px-2.5 py-2 text-xs font-medium text-muted hover:text-grape whitespace-nowrap">Cancel</button>
                                </div>
                            </div>
                        </div>
                        @error('insurance_type')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Insurance Valid Date --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Insurance Valid Date
                            <input name="insurance_valid_until" type="date" value="{{ old('insurance_valid_until') }}" class="pdi-field">
                        </label>
                        @error('insurance_valid_until')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Conditional Insurance Upload Box (Full width) --}}
                    <div data-insurance-upload-box class="pdi-col-span-2 @unless ($hasInsurance) hidden @endunless rounded-xl border border-purple/30 bg-lilac/30 p-4 space-y-2">
                        <div class="flex items-center gap-2 text-xs font-bold text-purple uppercase tracking-wider">
                            <svg class="size-4 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                            Upload Insurance Document (Image or PDF)
                        </div>
                        <div class="rounded-lg border border-white bg-white/80 p-3 shadow-xs">
                            <input type="file" name="insurance_file" accept="image/*,application/pdf" class="block w-full text-xs text-muted file:mr-2.5 file:rounded-lg file:border-0 file:bg-purple file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-purple/90">
                        </div>
                        @error('insurance_file')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            {{-- Card 5: Customer, Pricing & Commercial Details --}}
            <div class="pdi-card">
                <div class="flex items-center gap-2.5 border-b border-mist pb-3 mb-5">
                    <span class="grid size-8 place-items-center rounded-lg bg-lilac text-purple">
                        <svg class="size-4.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </span>
                    <div>
                        <h2 class="text-base font-bold text-grape">5. Pricing & Customer Information</h2>
                        <p class="text-xs text-muted">Customer name, estimated expenses, pricing, and inspector remarks</p>
                    </div>
                </div>

                <div class="pdi-grid">
                    {{-- Customer Name --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Customer Name
                            <input name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer full name" class="pdi-field">
                        </label>
                        @error('customer_name')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- File Number --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">File Number
                            <input name="file_number" value="{{ old('file_number') }}" placeholder="e.g. FILE-1049" class="pdi-field">
                        </label>
                        @error('file_number')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Approx Exp of Vehicle --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Approx Exp of Vehicle
                            <input name="approx_expense" value="{{ old('approx_expense') }}" placeholder="e.g. ₹ 25,000" class="pdi-field">
                        </label>
                        @error('approx_expense')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Market Value --}}
                    <div>
                        <label class="block text-sm font-medium text-grape">Market Value
                            <input name="market_value" value="{{ old('market_value') }}" placeholder="e.g. ₹ 7,50,000" class="pdi-field">
                        </label>
                        @error('market_value')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Sale Price --}}
                    <div class="pdi-col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-grape">Sale Price
                            <input name="sale_price" value="{{ old('sale_price') }}" placeholder="e.g. ₹ 6,80,000" class="pdi-field">
                        </label>
                        @error('sale_price')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>

                    {{-- Remark (Full width) --}}
                    <div class="pdi-col-span-2">
                        <label class="block text-sm font-medium text-grape">Remark
                            <textarea name="remark" rows="3" placeholder="Enter any general inspection notes, vehicle condition summary, or key observations..." class="pdi-field">{{ old('remark') }}</textarea>
                        </label>
                        @error('remark')<span class="mt-1 block text-xs text-purple font-medium">{{ $message }}</span>@enderror
                    </div>
                </div>
            </div>

            @foreach ($checklist as $section => $items)
                @php
                    $sectionHasError = collect(array_keys($items))->contains(
                        fn (string $key): bool => $errors->has("items.{$key}.photo") || $errors->has("items.{$key}.score")
                    );
                @endphp
                <details class="group overflow-hidden rounded-2xl border border-mist bg-white" @if ($loop->first || $sectionHasError) open @endif>
                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-6 py-5">
                        <span>
                            <span class="block text-lg font-bold">{{ $section }}</span>
                            <span class="mt-1 block text-sm text-muted">{{ count($items) }} photos. Tap the stars, then add a photo for each check.</span>
                        </span>
                        <span class="grid size-9 shrink-0 place-items-center rounded-full bg-lilac text-purple">
                            <svg class="size-5 transition duration-200 group-open:rotate-180" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m6 9 6 6 6-6" /></svg>
                        </span>
                    </summary>
                    <div class="divide-y divide-mist border-t border-mist px-6">
                        @foreach ($items as $key => $label)
                            @php
                                $uploaded = $uploads[$key] ?? null;
                                $score = (int) old("items.{$key}.score", 0);
                                $scoreColorClass = match (true) {
                                    $score >= 8 => 'text-emerald-600',
                                    $score >= 5 => 'text-amber-500',
                                    $score >= 1 => 'text-red-600',
                                    default => 'text-muted',
                                };
                            @endphp
                            <div data-item-row class="flex items-center gap-4 py-4">
                                <label class="relative flex size-20 shrink-0 cursor-pointer items-center justify-center overflow-hidden rounded-xl border border-dashed border-purple/40 bg-lilac">
                                    <img data-preview alt="" class="absolute inset-0 size-full object-cover" @unless ($uploaded) hidden @endunless @if ($uploaded) src="{{ asset('storage/'.$uploaded) }}" @endif>
                                    <span data-placeholder class="text-xs font-semibold text-purple" @if ($uploaded) hidden @endif>Photo</span>
                                    <input data-photo data-item="{{ $key }}" type="file" accept="image/*" class="sr-only" @unless ($uploaded) required @endunless>
                                </label>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm text-grape/80">{{ $label }}</p>
                                    <div class="mt-2 flex flex-wrap gap-0.5" data-stars>
                                        @for ($star = 1; $star <= 10; $star++)
                                            <button type="button" data-star="{{ $star }}" class="text-mist" aria-label="{{ $star }} out of 10">
                                                <svg class="size-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2.8 14.7 8.7l6.5.6-4.9 4.2 1.5 6.3L12 16.8 6.2 19.8l1.5-6.3L2.8 9.3l6.5-.6L12 2.8Z" /></svg>
                                            </button>
                                        @endfor
                                    </div>
                                    <p data-photo-status class="mt-1 text-xs text-muted">{{ $uploaded ? 'Photo ready' : '' }}</p>
                                    <input data-score type="hidden" name="items[{{ $key }}][score]" value="{{ old("items.{$key}.score") }}">
                                    @error("items.{$key}.photo")<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                                    @error("items.{$key}.score")<span class="mt-1 block text-sm text-purple">{{ $message }}</span>@enderror
                                </div>
                                <div class="shrink-0 self-center text-right">
                                    <span data-score-badge aria-live="polite" style="min-width: 4.25rem;" class="inline-flex items-center justify-center rounded-xl border border-mist bg-lilac/50 px-3 py-1.5 text-sm font-bold tracking-tight tabular-nums sm:text-base {{ $scoreColorClass }}">
                                        {{ sprintf('%02d/10', $score) }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </details>
            @endforeach

            @auth('web')
                <button type="submit" data-save class="rounded-full bg-purple px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple/25 disabled:opacity-60">Save inspection</button>
            @else
                <p class="text-sm text-muted">Log in on the website to save this inspection.</p>
                <a href="{{ route('login') }}" class="inline-flex rounded-full bg-purple px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-purple/25">Login to save</a>
            @endauth
        </form>
    </section>
    <script>
        let photoQueue = Promise.resolve();
        let photosUploading = 0;

        document.querySelectorAll('[data-photo]').forEach((input) => {
            input.addEventListener('change', () => {
                const frame = input.closest('label');
                const preview = frame.querySelector('[data-preview]');
                const placeholder = frame.querySelector('[data-placeholder]');
                const status = frame.parentElement.querySelector('[data-photo-status]');
                const file = input.files[0];
                const save = document.querySelector('[data-save]');

                if (! file || ! file.type.startsWith('image/')) {
                    return;
                }

                preview.src = URL.createObjectURL(file);
                preview.hidden = false;
                placeholder.hidden = true;

                if (! save) {
                    return;
                }

                const body = new FormData();
                body.append('item', input.dataset.item);
                body.append('photo', file);

                photosUploading += 1;
                save.disabled = true;
                status.textContent = 'Uploading photo…';

                photoQueue = photoQueue.then(async () => {
                    try {
                        const response = await fetch(@json(route('pdi.photo')), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                            },
                            body,
                        });

                        if (! response.ok) {
                            status.textContent = 'Photo was not saved. Choose it again.';
                            return;
                        }

                        input.removeAttribute('required');
                        status.textContent = 'Photo ready';
                    } finally {
                        photosUploading -= 1;

                        if (photosUploading === 0) {
                            save.disabled = false;
                        }
                    }
                });
            });
        });

        document.querySelectorAll('[data-stars]').forEach((group) => {
            const row = group.closest('[data-item-row]');
            const scoreInput = row.querySelector('[data-score]');
            const badge = row.querySelector('[data-score-badge]');

            const paint = (value) => {
                group.querySelectorAll('[data-star]').forEach((star) => {
                    const filled = Number(star.dataset.star) <= value;

                    star.classList.toggle('text-amber-400', filled);
                    star.classList.toggle('text-mist', ! filled);
                });

                if (badge) {
                    badge.textContent = `${String(value).padStart(2, '0')}/10`;
                    badge.classList.remove('text-muted', 'text-red-600', 'text-amber-500', 'text-emerald-600');

                    if (value >= 8) {
                        badge.classList.add('text-emerald-600');
                    } else if (value >= 5) {
                        badge.classList.add('text-amber-500');
                    } else if (value >= 1) {
                        badge.classList.add('text-red-600');
                    } else {
                        badge.classList.add('text-muted');
                    }
                }
            };

            paint(Number(scoreInput.value || 0));

            group.querySelectorAll('[data-star]').forEach((star) => {
                star.addEventListener('click', () => {
                    scoreInput.value = star.dataset.star;
                    paint(Number(star.dataset.star));
                });
            });
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

        const persistDropdownOption = (category, name) => {
            if (! category || ! name) return;
            fetch(@json(route('pdi.options')), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ category, name }),
            }).catch(() => {});
        };

        const setupCustomDropdown = (categoryKey) => {
            const select = document.querySelector(`[data-custom-select="${categoryKey}"]`);
            const box = document.querySelector(`[data-custom-box="${categoryKey}"]`);
            const input = document.querySelector(`[data-custom-input="${categoryKey}"]`);
            const addBtn = document.querySelector(`[data-custom-add="${categoryKey}"]`);
            const cancelBtn = document.querySelector(`[data-custom-cancel="${categoryKey}"]`);
            const toggleBtn = document.querySelector(`[data-custom-toggle="${categoryKey}"]`);

            if (! select || ! box || ! input) {
                return;
            }

            let previousValue = select.value !== '__other__' ? select.value : '';

            const showBox = () => {
                box.classList.remove('hidden');
                setTimeout(() => input.focus(), 50);
            };

            const hideBox = () => {
                box.classList.add('hidden');
            };

            const applyCustomValue = () => {
                const val = input.value.trim();
                if (! val) {
                    input.focus();
                    return false;
                }

                let foundOption = Array.from(select.options).find(
                    (opt) => opt.value !== '__other__' && opt.value.toLowerCase() === val.toLowerCase()
                );

                if (! foundOption) {
                    foundOption = document.createElement('option');
                    foundOption.value = val;
                    foundOption.textContent = val;
                    const otherOption = select.querySelector('option[value="__other__"]');
                    select.insertBefore(foundOption, otherOption);
                }

                select.value = foundOption.value;
                previousValue = foundOption.value;
                persistDropdownOption(categoryKey, val);
                hideBox();
                input.value = '';
                select.dispatchEvent(new Event('change', { bubbles: true }));
                return true;
            };

            select.addEventListener('change', () => {
                if (select.value === '__other__') {
                    showBox();
                } else {
                    previousValue = select.value;
                    hideBox();
                }
            });

            if (toggleBtn) {
                toggleBtn.addEventListener('click', () => {
                    select.value = '__other__';
                    showBox();
                });
            }

            if (addBtn) {
                addBtn.addEventListener('click', applyCustomValue);
            }

            if (cancelBtn) {
                cancelBtn.addEventListener('click', () => {
                    hideBox();
                    input.value = '';
                    select.value = previousValue;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                });
            }

            input.addEventListener('keydown', (e) => {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    applyCustomValue();
                } else if (e.key === 'Escape') {
                    e.preventDefault();
                    hideBox();
                    select.value = previousValue;
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        };

        const dropdownKeys = ['inspector', 'brand', 'model', 'location', 'rc_status', 'insurance_type'];
        dropdownKeys.forEach(setupCustomDropdown);

        // RC upload visibility toggle
        const rcSelect = document.querySelector('[data-custom-select="rc_status"]');
        const rcBox = document.querySelector('[data-rc-upload-box]');
        const updateRcUploadVisibility = () => {
            if (! rcSelect || ! rcBox) return;
            const val = (rcSelect.value || '').toLowerCase().trim();
            const isAvailable = val !== '' && val !== '__other__' && (
                val.includes('available') ||
                val.includes('avilable') ||
                val.includes('abailble') ||
                val.includes('drc') ||
                val.includes('plain') ||
                val.includes('rc')
            );
            rcBox.classList.toggle('hidden', ! isAvailable);
        };
        if (rcSelect) {
            rcSelect.addEventListener('change', updateRcUploadVisibility);
            updateRcUploadVisibility();
        }

        // Insurance upload visibility toggle
        const insSelect = document.querySelector('[data-custom-select="insurance_type"]');
        const insBox = document.querySelector('[data-insurance-upload-box]');
        const updateInsuranceUploadVisibility = () => {
            if (! insSelect || ! insBox) return;
            const val = (insSelect.value || '').toLowerCase().trim();
            const hasInsurance = val !== '' && val !== '__other__' &&
                ! val.includes('expired') &&
                ! val.includes('none') &&
                ! val.includes('no insurance');
            insBox.classList.toggle('hidden', ! hasInsurance);
        };
        if (insSelect) {
            insSelect.addEventListener('change', updateInsuranceUploadVisibility);
            updateInsuranceUploadVisibility();
        }

        // 17-character Chassis Number formatting and counter
        const chassisInput = document.getElementById('chassis-input');
        const chassisCounter = document.querySelector('[data-chassis-counter]');
        if (chassisInput && chassisCounter) {
            const updateChassis = () => {
                const clean = chassisInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '').slice(0, 17);
                if (chassisInput.value !== clean) {
                    chassisInput.value = clean;
                }
                const len = clean.length;
                chassisCounter.textContent = `${len}/17 characters`;
                if (len === 17) {
                    chassisCounter.className = 'text-xs font-mono font-bold text-emerald-600';
                } else if (len > 0) {
                    chassisCounter.className = 'text-xs font-mono font-medium text-amber-500';
                } else {
                    chassisCounter.className = 'text-xs font-mono text-muted';
                }
            };
            chassisInput.addEventListener('input', updateChassis);
            updateChassis();
        }

        const pdiForm = document.querySelector('form');
        if (pdiForm) {
            pdiForm.addEventListener('submit', (e) => {
                for (const name of dropdownKeys) {
                    const select = document.querySelector(`[data-custom-select="${name}"]`);
                    const input = document.querySelector(`[data-custom-input="${name}"]`);
                    const box = document.querySelector(`[data-custom-box="${name}"]`);

                    if (select && select.value === '__other__') {
                        const val = input ? input.value.trim() : '';
                        if (! val) {
                            e.preventDefault();
                            box?.classList.remove('hidden');
                            input?.focus();
                            return;
                        }

                        let foundOption = Array.from(select.options).find(
                            (opt) => opt.value.toLowerCase() === val.toLowerCase()
                        );

                        if (! foundOption) {
                            foundOption = document.createElement('option');
                            foundOption.value = val;
                            foundOption.textContent = val;
                            select.insertBefore(foundOption, select.querySelector('option[value="__other__"]'));
                        }

                        select.value = foundOption.value;
                    }
                }
            });
        }
    </script>
@endsection
