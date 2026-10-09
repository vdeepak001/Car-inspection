@extends('layouts.admin')

@section('heading', 'Edit user')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @include('admin.users.form', [
                'user' => $user,
                'action' => route('admin.users.update', $user),
                'method' => 'PUT',
                'heading' => 'Edit '.$user->name,
                'button' => 'Save changes',
            ])
        </div>
    </div>
@endsection
