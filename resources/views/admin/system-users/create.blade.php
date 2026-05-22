@extends('layouts.app')

@section('title', 'Create System User')
@section('page-title', 'Create System User')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">
        <h5 class="mb-0">Create System User</h5>
    </div>

    <div class="card-body">

        <form
            action="{{ route('admin.system-users.store') }}"
            method="POST">

            @include('admin.system-users.partials.form')

        </form>

    </div>

</div>

@endsection