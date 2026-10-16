@extends('layouts.admin')

@php
    $saved = $inspection->items->keyBy('item_key');
    $shownKeys = [];
@endphp

@section('heading', $inspection->brand.' '.$inspection->model_name)

@section('actions')
    <div class="d-flex align-items-center gap-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInspectionModal">
            <i class="ti ti-edit me-1"></i> Edit Details
        </button>

        @if ($inspection->status === 'pending')
            <form method="POST" action="{{ route('admin.inspections.status', $inspection) }}" class="m-0">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="completed">
                <button type="submit" class="btn btn-success">
                    <i class="ti ti-check me-1"></i> Mark as Completed
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('admin.inspections.status', $inspection) }}" class="m-0">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="pending">
                <button type="submit" class="btn btn-outline-warning">
                    <i class="ti ti-clock me-1"></i> Mark as Pending
                </button>
            </form>
        @endif
        <a href="{{ route('admin.inspections.index') }}" class="btn btn-outline-secondary">Back</a>
    </div>
@endsection

@section('content')
    <div class="row row-cards mb-3">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Website account</h3>
                    @if ($inspection->user)
                        <a href="{{ route('admin.users.edit', $inspection->user) }}" class="btn btn-sm btn-outline-primary" title="Edit user account">
                            <i class="ti ti-edit me-1"></i> Edit User
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @if ($inspection->user)
                        <div class="datagrid">
                            <div class="datagrid-item">
                                <div class="datagrid-title">Name</div>
                                <div class="datagrid-content">{{ $inspection->user->name }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Phone number</div>
                                <div class="datagrid-content">{{ $inspection->user->phone ?? 'No phone' }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Email</div>
                                <div class="datagrid-content">{{ $inspection->user->email }}</div>
                            </div>
                            <div class="datagrid-item">
                                <div class="datagrid-title">Role</div>
                                <div class="datagrid-content">
                                    @if ($inspection->user->isAdmin())
                                        <span class="badge bg-primary-lt">Admin</span>
                                    @else
                                        <span class="badge bg-green-lt">Member</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('admin.users.show', $inspection->user) }}" class="btn btn-sm btn-outline-primary mt-3">Open account</a>
                    @else
                        <p class="text-secondary mb-0">The website account for this inspection was removed.</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" style="height: 28px; object-fit: contain;">
                        <h3 class="card-title mb-0">Inspection details</h3>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editInspectionModal">
                        <i class="ti ti-edit me-1"></i> Edit Details
                    </button>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Overall rating</div>
                            <div class="datagrid-content fw-bold">{{ number_format((float) $inspection->overall_rating, 1) }}/10</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Status</div>
                            <div class="datagrid-content">
                                @if ($inspection->status === 'completed')
                                    <span class="badge bg-green-lt text-uppercase"><i class="ti ti-check me-1"></i>Completed</span>
                                @else
                                    <span class="badge bg-warning-lt text-uppercase"><i class="ti ti-clock me-1"></i>Pending</span>
                                @endif
                            </div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Inspector</div>
                            <div class="datagrid-content">{{ $inspection->inspector }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Date of PDI</div>
                            <div class="datagrid-content">{{ $inspection->inspected_on?->format('d M Y') ?? 'No date' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Brand</div>
                            <div class="datagrid-content">{{ $inspection->brand }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Model</div>
                            <div class="datagrid-content">{{ $inspection->model_name }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Vehicle Number</div>
                            <div class="datagrid-content text-uppercase fw-bold">{{ $inspection->vehicle_number ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Chassis Number</div>
                            <div class="datagrid-content text-uppercase fw-bold font-monospace">{{ $inspection->chassis_number ?: ($inspection->vin ?: 'Not provided') }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Variant</div>
                            <div class="datagrid-content">{{ $inspection->vehicle_variant ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Location</div>
                            <div class="datagrid-content">{{ $inspection->location }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">RTO Location</div>
                            <div class="datagrid-content">{{ $inspection->rto_location ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">RC Status</div>
                            <div class="datagrid-content">{{ $inspection->rc_status ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">RC Valid Date</div>
                            <div class="datagrid-content">{{ $inspection->rc_valid_until?->format('d M Y') ?? 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Insurance</div>
                            <div class="datagrid-content">{{ $inspection->insurance_type ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Insurance Valid Date</div>
                            <div class="datagrid-content">{{ $inspection->insurance_valid_until?->format('d M Y') ?? 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Customer Name</div>
                            <div class="datagrid-content">{{ $inspection->customer_name ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Approx Expense</div>
                            <div class="datagrid-content">{{ $inspection->approx_expense ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Market Value</div>
                            <div class="datagrid-content">{{ $inspection->market_value ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Sale Price</div>
                            <div class="datagrid-content">{{ $inspection->sale_price ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">File Number</div>
                            <div class="datagrid-content">{{ $inspection->file_number ?: 'Not provided' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Engine number</div>
                            <div class="datagrid-content">{{ $inspection->engine_number ?: 'No engine number' }}</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Saved</div>
                            <div class="datagrid-content">{{ $inspection->created_at?->format('d M Y H:i') }}</div>
                        </div>
                        @if ($inspection->remark)
                            <div class="datagrid-item w-100">
                                <div class="datagrid-title">Remark</div>
                                <div class="datagrid-content">{{ $inspection->remark }}</div>
                            </div>
                        @endif
                    </div>
                    @if ($inspection->rc_front_photo || $inspection->rc_back_photo || $inspection->insurance_photo)
                        <div class="mt-4 pt-3 border-top">
                            <div class="fw-bold mb-2">Uploaded Documents</div>
                            <div class="d-flex flex-wrap gap-2">
                                @if ($inspection->rc_front_photo)
                                    <a href="{{ asset('storage/'.$inspection->rc_front_photo) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-file me-1"></i> RC Front
                                    </a>
                                @endif
                                @if ($inspection->rc_back_photo)
                                    <a href="{{ asset('storage/'.$inspection->rc_back_photo) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-file me-1"></i> RC Back
                                    </a>
                                @endif
                                @if ($inspection->insurance_photo)
                                    <a href="{{ asset('storage/'.$inspection->insurance_photo) }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                        <i class="ti ti-shield me-1"></i> Insurance Policy
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @foreach ($checklist as $section => $labels)
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">{{ $section }}</h3>
            </div>
            <div class="card-body">
                <div class="row row-cards">
                    @foreach ($labels as $key => $label)
                        @php
                            $item = $saved->get($key);
                            $shownKeys[] = $key;
                        @endphp
                        <div class="col-sm-6 col-lg-4">
                            <div class="border rounded p-3 h-100 d-flex flex-column justify-content-between position-relative shadow-sm bg-body">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div class="fw-semibold text-truncate pe-2" title="{{ $item->label ?? $label }}">{{ $item->label ?? $label }}</div>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $key }}" title="Edit {{ $item->label ?? $label }}">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </div>
                                    @if ($item)
                                        <div class="text-warning mb-2" aria-label="{{ $item->score }} out of 10">
                                            @for ($star = 1; $star <= 10; $star++)
                                                <i class="ti {{ $star <= $item->score ? 'ti-star-filled' : 'ti-star' }}"></i>
                                            @endfor
                                            <span class="text-body fw-bold ms-1">{{ $item->score }}/10</span>
                                        </div>
                                        @if ($item->photo)
                                            <a href="{{ asset('storage/'.$item->photo) }}" target="_blank" rel="noopener" class="d-block">
                                                <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->label }}" class="img-fluid rounded w-100 border" style="height: 180px; object-fit: cover;">
                                            </a>
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-secondary border" style="height: 180px;">
                                                <span><i class="ti ti-photo-off me-1"></i> No photo</span>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-secondary small mb-2"><i class="ti ti-info-circle me-1"></i> Not recorded</div>
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-secondary border" style="height: 180px;">
                                            <span class="text-muted"><i class="ti ti-plus me-1"></i> Click edit to record</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Modal for editing checklist item --}}
                        <div class="modal modal-blur fade" id="modal-edit-{{ $key }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.inspections.items.update', [$inspection, $key]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="section" value="{{ $item->section ?? $section }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center gap-2">
                                                <i class="ti ti-edit text-primary"></i>
                                                <span>Edit: {{ $item->label ?? $label }}</span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label required">Score (Rating out of 10)</label>
                                                <select name="score" class="form-select" required>
                                                    @for ($s = 10; $s >= 1; $s--)
                                                        <option value="{{ $s }}" @selected((int) old('score', $item->score ?? 5) === $s)>
                                                            {{ $s }} / 10 {{ $s >= 8 ? '⭐ Excellent' : ($s >= 5 ? 'Good' : 'Needs attention') }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Check Title / Label</label>
                                                <input type="text" name="label" class="form-control" value="{{ old('label', $item->label ?? $label) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Check Photo {{ $item?->photo ? '(Upload new to replace)' : '' }}</label>
                                                @if ($item?->photo)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/'.$item->photo) }}" alt="Current Photo" class="rounded border" style="height: 100px; width: 140px; object-fit: cover;">
                                                        <div class="small text-muted mt-1">Current inspection photo</div>
                                                    </div>
                                                @endif
                                                <input type="file" name="photo" class="form-control" accept="image/*">
                                                <div class="form-hint small">Supported formats: JPG, PNG, WEBP. Max size: 10MB.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary ms-auto">
                                                <i class="ti ti-device-floppy me-1"></i> Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach

    @php
        $extraItems = $inspection->items->reject(fn ($item) => in_array($item->item_key, $shownKeys, true));
    @endphp

    @if ($extraItems->isNotEmpty())
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Other checks</h3>
            </div>
            <div class="card-body">
                <div class="row row-cards">
                    @foreach ($extraItems as $item)
                        <div class="col-sm-6 col-lg-4">
                            <div class="border rounded p-3 h-100 d-flex flex-column justify-content-between position-relative shadow-sm bg-body">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="text-secondary small">{{ $item->section }}</div>
                                            <div class="fw-semibold">{{ $item->label }}</div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-icon btn-outline-primary flex-shrink-0" data-bs-toggle="modal" data-bs-target="#modal-edit-{{ $item->item_key }}" title="Edit {{ $item->label }}">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                    </div>
                                    <div class="text-warning mb-2">
                                        @for ($star = 1; $star <= 10; $star++)
                                            <i class="ti {{ $star <= $item->score ? 'ti-star-filled' : 'ti-star' }}"></i>
                                        @endfor
                                        <span class="text-body fw-bold ms-1">{{ $item->score }}/10</span>
                                    </div>
                                    @if ($item->photo)
                                        <a href="{{ asset('storage/'.$item->photo) }}" target="_blank" rel="noopener">
                                            <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->label }}" class="img-fluid rounded w-100 border" style="height: 180px; object-fit: cover;">
                                        </a>
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center text-secondary border" style="height: 180px;">
                                            <span><i class="ti ti-photo-off me-1"></i> No photo</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Modal for extra check item --}}
                        <div class="modal modal-blur fade" id="modal-edit-{{ $item->item_key }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.inspections.items.update', [$inspection, $item->item_key]) }}" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="section" value="{{ $item->section }}">
                                        <div class="modal-header">
                                            <h5 class="modal-title d-flex align-items-center gap-2">
                                                <i class="ti ti-edit text-primary"></i>
                                                <span>Edit: {{ $item->label }}</span>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label required">Score (Rating out of 10)</label>
                                                <select name="score" class="form-select" required>
                                                    @for ($s = 10; $s >= 1; $s--)
                                                        <option value="{{ $s }}" @selected((int) old('score', $item->score) === $s)>
                                                            {{ $s }} / 10 {{ $s >= 8 ? '⭐ Excellent' : ($s >= 5 ? 'Good' : 'Needs attention') }}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Check Title / Label</label>
                                                <input type="text" name="label" class="form-control" value="{{ old('label', $item->label) }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Check Photo {{ $item->photo ? '(Upload new to replace)' : '' }}</label>
                                                @if ($item->photo)
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/'.$item->photo) }}" alt="Current Photo" class="rounded border" style="height: 100px; width: 140px; object-fit: cover;">
                                                        <div class="small text-muted mt-1">Current inspection photo</div>
                                                    </div>
                                                @endif
                                                <input type="file" name="photo" class="form-control" accept="image/*">
                                                <div class="form-hint small">Supported formats: JPG, PNG, WEBP. Max size: 10MB.</div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary ms-auto">
                                                <i class="ti ti-device-floppy me-1"></i> Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- Comprehensive Modal for Inspection Details Card --}}
    <div class="modal modal-blur fade" id="editInspectionModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.inspections.update', $inspection) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title d-flex align-items-center gap-2">
                            <i class="ti ti-edit text-primary fs-3"></i>
                            <span>Edit Inspection Details & Vehicle Information</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        {{-- Section 1: Vehicle & Model Details --}}
                        <div class="subheader mb-2 text-primary fw-bold"><i class="ti ti-car me-1"></i> Vehicle & Model Information</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label required">Brand</label>
                                <input type="text" name="brand" class="form-control" value="{{ old('brand', $inspection->brand) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Model</label>
                                <input type="text" name="model_name" class="form-control" value="{{ old('model_name', $inspection->model_name) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Variant</label>
                                <input type="text" name="vehicle_variant" class="form-control" value="{{ old('vehicle_variant', $inspection->vehicle_variant) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Vehicle Registration Number</label>
                                <input type="text" name="vehicle_number" class="form-control text-uppercase" value="{{ old('vehicle_number', $inspection->vehicle_number) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Chassis Number (VIN)</label>
                                <input type="text" name="chassis_number" class="form-control text-uppercase font-monospace" maxlength="17" value="{{ old('chassis_number', $inspection->chassis_number ?: $inspection->vin) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Engine Number</label>
                                <input type="text" name="engine_number" class="form-control text-uppercase" value="{{ old('engine_number', $inspection->engine_number) }}">
                            </div>
                        </div>

                        {{-- Section 2: Inspection Location & Dates --}}
                        <div class="subheader mb-2 text-primary fw-bold"><i class="ti ti-map-pin me-1"></i> Location & Inspection Information</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label required">Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location', $inspection->location) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RTO Location</label>
                                <input type="text" name="rto_location" class="form-control" value="{{ old('rto_location', $inspection->rto_location) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">Inspector Name</label>
                                <input type="text" name="inspector" class="form-control" value="{{ old('inspector', $inspection->inspector) }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Date of PDI</label>
                                <input type="date" name="inspected_on" class="form-control" value="{{ old('inspected_on', $inspection->inspected_on?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label required">PDI Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="pending" @selected(old('status', $inspection->status) === 'pending')>Pending</option>
                                    <option value="completed" @selected(old('status', $inspection->status) === 'completed')>Completed</option>
                                </select>
                            </div>
                        </div>

                        {{-- Section 3: Registration & Insurance Details --}}
                        <div class="subheader mb-2 text-primary fw-bold"><i class="ti ti-file-certificate me-1"></i> Registration & Insurance Documents</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-3">
                                <label class="form-label">RC Status</label>
                                <select name="rc_status" class="form-select">
                                    <option value="">Select RC Status</option>
                                    <option value="Available" @selected(old('rc_status', $inspection->rc_status) === 'Available')>Available</option>
                                    <option value="Applied" @selected(old('rc_status', $inspection->rc_status) === 'Applied')>Applied</option>
                                    <option value="Duplicate" @selected(old('rc_status', $inspection->rc_status) === 'Duplicate')>Duplicate</option>
                                    <option value="Not Available" @selected(old('rc_status', $inspection->rc_status) === 'Not Available')>Not Available</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RC Valid Date</label>
                                <input type="date" name="rc_valid_until" class="form-control" value="{{ old('rc_valid_until', $inspection->rc_valid_until?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RC Front Document</label>
                                <input type="file" name="rc_front_photo" class="form-control" accept="image/*,application/pdf">
                                @if ($inspection->rc_front_photo)
                                    <div class="small mt-1"><a href="{{ asset('storage/'.$inspection->rc_front_photo) }}" target="_blank" rel="noopener"><i class="ti ti-external-link me-1"></i>View Current Front</a></div>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">RC Back Document</label>
                                <input type="file" name="rc_back_photo" class="form-control" accept="image/*,application/pdf">
                                @if ($inspection->rc_back_photo)
                                    <div class="small mt-1"><a href="{{ asset('storage/'.$inspection->rc_back_photo) }}" target="_blank" rel="noopener"><i class="ti ti-external-link me-1"></i>View Current Back</a></div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Insurance Type</label>
                                <select name="insurance_type" class="form-select">
                                    <option value="">Select Insurance Type</option>
                                    <option value="Comprehensive" @selected(old('insurance_type', $inspection->insurance_type) === 'Comprehensive')>Comprehensive</option>
                                    <option value="Third Party" @selected(old('insurance_type', $inspection->insurance_type) === 'Third Party')>Third Party</option>
                                    <option value="Zero Dep" @selected(old('insurance_type', $inspection->insurance_type) === 'Zero Dep')>Zero Dep</option>
                                    <option value="Expired" @selected(old('insurance_type', $inspection->insurance_type) === 'Expired')>Expired</option>
                                    <option value="Not Available" @selected(old('insurance_type', $inspection->insurance_type) === 'Not Available')>Not Available</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Insurance Valid Date</label>
                                <input type="date" name="insurance_valid_until" class="form-control" value="{{ old('insurance_valid_until', $inspection->insurance_valid_until?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Insurance Policy Document</label>
                                <input type="file" name="insurance_photo" class="form-control" accept="image/*,application/pdf">
                                @if ($inspection->insurance_photo)
                                    <div class="small mt-1"><a href="{{ asset('storage/'.$inspection->insurance_photo) }}" target="_blank" rel="noopener"><i class="ti ti-external-link me-1"></i>View Current Policy</a></div>
                                @endif
                            </div>
                        </div>

                        {{-- Section 4: Customer, File & Financial Details --}}
                        <div class="subheader mb-2 text-primary fw-bold"><i class="ti ti-currency-rupee me-1"></i> Valuation & Customer Details</div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $inspection->customer_name) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">File Number</label>
                                <input type="text" name="file_number" class="form-control" value="{{ old('file_number', $inspection->file_number) }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Approx Expense</label>
                                <input type="text" name="approx_expense" class="form-control" value="{{ old('approx_expense', $inspection->approx_expense) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Market Value</label>
                                <input type="text" name="market_value" class="form-control" value="{{ old('market_value', $inspection->market_value) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sale Price</label>
                                <input type="text" name="sale_price" class="form-control" value="{{ old('sale_price', $inspection->sale_price) }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Remark / Notes</label>
                                <textarea name="remark" class="form-control" rows="3">{{ old('remark', $inspection->remark) }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-auto">
                            <i class="ti ti-device-floppy me-1"></i> Save Inspection Details
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
