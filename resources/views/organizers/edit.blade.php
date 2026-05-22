@extends('layouts.app')

@section('title', 'Edit Organizer')
@section('page-title', 'Edit Organizer')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('organizers.index') }}">Organizers</a>
    </li>
    <li class="breadcrumb-item active">Edit Organizer</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Edit Organizer</h5>
    </div>

    <div class="card-body">
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('organizers.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name', $data->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile"
                        class="form-control @error('mobile') is-invalid @enderror"
                        value="{{ old('mobile', $data->mobile) }}" required>
                    @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $data->email) }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-control @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active', $data->is_active) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', $data->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Organizer</button>
            <a href="{{ route('organizers.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

@endsection