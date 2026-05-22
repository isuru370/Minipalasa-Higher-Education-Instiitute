@extends('layouts.app')

@section('title', 'Edit System User')
@section('page-title', 'Edit System User')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">
        <h5 class="mb-0">Edit System User</h5>
    </div>

    <div class="card-body">

        <form
            action="{{ route('admin.system-users.update', $systemUser) }}"
            method="POST">

            @csrf
            @method('PUT')

            @include('admin.system-users.partials.form')

        </form>

    </div>

</div>

@endsection