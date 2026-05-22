@extends('layouts.app')

@section('title', 'Organizers')
@section('page-title', 'Manage Organizers')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Organizers</li>
@endsection

@section('content')

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Organizer List</h5>
        <a href="{{ route('organizers.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-user-plus"></i> Add Organizer
        </a>
    </div>

    <div class="card-body">

        {{-- Success / Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if($data->isEmpty())
            <div class="alert alert-info mb-0">
                No organizers found.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data as $key => $organizer)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $organizer->name }}</td>
                                <td>{{ $organizer->mobile ?? '-' }}</td>
                                <td>{{ $organizer->email ?? '-' }}</td>
                                <td>
                                    @if($organizer->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1 flex-wrap">

                                        {{-- Edit --}}
                                        <a href="{{ route('organizers.edit', $organizer->id) }}"
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>

                                        {{-- Toggle --}}
                                        <form action="{{ route('organizers.toggle', $organizer->id) }}"
                                              method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-info btn-sm"
                                                onclick="return confirm('Are you sure you want to change status?')">
                                                <i class="fas fa-sync-alt"></i>
                                                {{ $organizer->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>

                                        {{-- Delete --}}
                                        <form action="{{ route('organizers.destroy', $organizer->id) }}"
                                              method="POST"
                                              style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm"
                                                onclick="return confirm('Are you sure you want to delete this organizer?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>
</div>

@endsection