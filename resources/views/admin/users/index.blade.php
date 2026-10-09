@extends('layouts.admin')

@section('heading', 'Users')

@section('actions')
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="ti ti-plus me-1"></i> Add user
    </a>
@endsection

@section('content')
    <div class="row row-deck row-cards mb-3">
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Accounts</div>
                        <span class="avatar avatar-sm bg-primary-lt ms-auto"><i class="ti ti-users"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ $users->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Website members</div>
                        <span class="avatar avatar-sm bg-green-lt ms-auto"><i class="ti ti-user"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ $users->where('is_admin', false)->count() }}</div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="subheader">Admins</div>
                        <span class="avatar avatar-sm bg-azure-lt ms-auto"><i class="ti ti-shield"></i></span>
                    </div>
                    <div class="h1 mb-0 mt-2">{{ $users->where('is_admin', true)->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Accounts</h3>
        </div>
        <div class="table-responsive">
            <table class="table table-vcenter card-table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone number</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="fw-medium">{{ $user->name }}</td>
                            <td class="text-secondary">{{ $user->phone ?? 'No phone' }}</td>
                            <td class="text-secondary">{{ $user->email }}</td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge bg-primary-lt">Admin</span>
                                @else
                                    <span class="badge bg-green-lt">Member</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-secondary">No accounts yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
