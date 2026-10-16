@extends('layouts.admin')

@php
    $saved = $inspection->items->keyBy('item_key');
    $shownKeys = [];
@endphp

@section('heading', $inspection->brand.' '.$inspection->model_name)

@section('actions')
    <a href="{{ route('admin.inspections.index') }}" class="btn btn-outline-secondary">Back</a>
@endsection

@section('content')
    <div class="row row-cards mb-3">
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Website account</h3>
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
                <div class="card-header">
                    <h3 class="card-title">Inspection details</h3>
                </div>
                <div class="card-body">
                    <div class="datagrid">
                        <div class="datagrid-item">
                            <div class="datagrid-title">Overall rating</div>
                            <div class="datagrid-content fw-bold">{{ number_format((float) $inspection->overall_rating, 1) }}/10</div>
                        </div>
                        <div class="datagrid-item">
                            <div class="datagrid-title">Status</div>
                            <div class="datagrid-content"><span class="badge bg-green-lt">{{ $inspection->status }}</span></div>
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
                            <div class="border rounded p-3 h-100">
                                <div class="fw-medium">{{ $item->label ?? $label }}</div>
                                @if ($item)
                                    <div class="text-warning my-2" aria-label="{{ $item->score }} out of 10">
                                        @for ($star = 1; $star <= 10; $star++)
                                            <i class="ti {{ $star <= $item->score ? 'ti-star-filled' : 'ti-star' }}"></i>
                                        @endfor
                                        <span class="text-body ms-1">{{ $item->score }}/10</span>
                                    </div>
                                    @if ($item->photo)
                                        <a href="{{ asset('storage/'.$item->photo) }}" target="_blank" rel="noopener">
                                            <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->label }}" class="img-fluid rounded w-100" style="height: 180px; object-fit: cover;">
                                        </a>
                                    @else
                                        <p class="text-secondary mb-0">No photo</p>
                                    @endif
                                @else
                                    <p class="text-secondary mb-0 mt-2">Not recorded</p>
                                @endif
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
                            <div class="border rounded p-3 h-100">
                                <div class="text-secondary">{{ $item->section }}</div>
                                <div class="fw-medium">{{ $item->label }}</div>
                                <div class="my-2">{{ $item->score }}/10</div>
                                @if ($item->photo)
                                    <a href="{{ asset('storage/'.$item->photo) }}" target="_blank" rel="noopener">
                                        <img src="{{ asset('storage/'.$item->photo) }}" alt="{{ $item->label }}" class="img-fluid rounded w-100" style="height: 180px; object-fit: cover;">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
@endsection
