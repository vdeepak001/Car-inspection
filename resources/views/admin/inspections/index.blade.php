@extends('layouts.admin')

@section('heading', 'Inspections')

@section('content')
    <div class="row row-deck row-cards mb-3">
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Total inspections</div>
                        <span class="avatar avatar-sm bg-primary-lt ms-auto"><i class="ti ti-clipboard-check"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ $inspections->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Pending inspections</div>
                        <span class="avatar avatar-sm bg-warning-lt ms-auto"><i class="ti ti-clock"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2 text-warning">{{ $inspections->where('status', 'pending')->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Completed inspections</div>
                        <span class="avatar avatar-sm bg-success-lt ms-auto"><i class="ti ti-check"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2 text-success">{{ $inspections->where('status', 'completed')->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <img src="{{ asset('images/logo_theme.png') }}" alt="Mangal Finance" style="height: 28px; object-fit: contain;">
            <h3 class="card-title mb-0">Car PDI reports</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Location</th>
                        <th>Inspector</th>
                        <th>VIN</th>
                        <th>Date</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inspections as $inspection)
                        <tr>
                            <td class="fw-medium">{{ $inspection->user?->name ?? 'Account removed' }}</td>
                            <td class="text-secondary">{{ $inspection->user?->phone ?? 'No phone' }}</td>
                            <td class="text-secondary">{{ $inspection->user?->email ?? 'No email' }}</td>
                            <td>{{ $inspection->brand }}</td>
                            <td>{{ $inspection->model_name }}</td>
                            <td>{{ $inspection->location }}</td>
                            <td>{{ $inspection->inspector }}</td>
                            <td>{{ $inspection->vin }}</td>
                            <td class="text-nowrap">{{ $inspection->inspected_on?->format('d M Y') }}</td>
                            <td>{{ number_format((float) $inspection->overall_rating, 1) }}/10</td>
                            <td>
                                @if ($inspection->status === 'completed')
                                    <span class="badge bg-green-lt text-uppercase"><i class="ti ti-check me-1"></i>Completed</span>
                                @else
                                    <span class="badge bg-warning-lt text-uppercase"><i class="ti ti-clock me-1"></i>Pending</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end align-items-center gap-1">
                                    <a href="{{ route('admin.inspections.show', $inspection) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    @if ($inspection->status === 'pending')
                                        <form method="POST" action="{{ route('admin.inspections.status', $inspection) }}" class="d-inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn btn-sm btn-success" title="Mark as Completed">
                                                <i class="ti ti-check me-1"></i> Complete
                                            </button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.inspections.status', $inspection) }}" class="d-inline m-0">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-sm btn-outline-warning" title="Revert to Pending">
                                                <i class="ti ti-clock me-1"></i> Pending
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-secondary">No inspections yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
