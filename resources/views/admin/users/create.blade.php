@extends('layouts.admin')

@section('heading', 'Add user')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            @include('admin.users.form', [
                'user' => null,
                'action' => route('admin.users.store'),
                'method' => 'POST',
                'heading' => 'Create a user',
                'button' => 'Create user',
            ])
        </div>
    </div>
@endsection
