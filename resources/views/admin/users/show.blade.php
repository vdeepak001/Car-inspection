@extends('layouts.admin')

@section('heading', $user->name)

@section('actions')
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Account</h3>
        </div>
        <div class="card-body">
            <div class="datagrid">
                <div class="datagrid-item">
                    <div class="datagrid-title">Name</div>
                    <div class="datagrid-content">{{ $user->name }}</div>
                </div>
                <div class="datagrid-item">
                    <div class="datagrid-title">Phone number</div>
                    <div class="datagrid-content">{{ $user->phone ?? 'No phone' }}</div>
                </div>
                <div class="datagrid-item">
                    <div class="datagrid-title">Email</div>
                    <div class="datagrid-content">{{ $user->email }}</div>
                </div>
                <div class="datagrid-item">
                    <div class="datagrid-title">Password</div>
                    <div class="datagrid-content">Hidden. Saved passwords cannot be shown. Use Edit to set a new one, and use Show on that form to see what you type.</div>
                </div>
                <div class="datagrid-item">
                    <div class="datagrid-title">Role</div>
                    <div class="datagrid-content">
                        @if ($user->isAdmin())
                            <span class="badge bg-primary-lt">Admin</span>
                        @else
                            <span class="badge bg-green-lt">Member</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <div class="btn-list">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-link">Back</a>
                @unless (auth('admin')->user()?->is($user))
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline" onsubmit="return confirm('Delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                @endunless
            </div>
        </div>
    </div>
@endsection
