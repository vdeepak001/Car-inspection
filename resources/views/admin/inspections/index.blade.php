@extends('layouts.admin')

@section('heading', 'Inspections')

@section('content')
    <div class="row row-deck row-cards mb-3">
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Saved inspections</div>
                        <span class="avatar avatar-sm bg-primary-lt ms-auto"><i class="ti ti-clipboard-check"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ $inspections->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Car PDI reports</h3>
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
                            <td><span class="badge bg-green-lt">{{ $inspection->status }}</span></td>
                            <td class="text-end">
                                <a href="{{ route('admin.inspections.show', $inspection) }}" class="btn btn-sm btn-outline-secondary">View</a>
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
