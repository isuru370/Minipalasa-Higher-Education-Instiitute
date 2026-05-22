@extends('layouts.app')

@section('title', 'Create Organizer')
@section('page-title', 'Create New Organizer')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('organizers.index') }}">Organizers</a>
    </li>
    <li class="breadcrumb-item active">Create Organizer</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Add Organizer</h5>
    </div>

    <div class="card-body">

        {{-- Success / Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Form --}}
        <form action="{{ route('organizers.store') }}" method="POST">
            @csrf

            <div class="row">

                {{-- Name --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" required>

                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Mobile --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Mobile</label>
                    <input type="text" name="mobile"
                        class="form-control @error('mobile') is-invalid @enderror"
                        value="{{ old('mobile') }}" required>

                    @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email (optional)</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}">

                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active"
                        class="form-control @error('is_active') is-invalid @enderror">
                        <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                    </select>

                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            {{-- Buttons --}}
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save Organizer
                </button>

                <a href="{{ route('organizers.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

    </div>
</div>

@endsection