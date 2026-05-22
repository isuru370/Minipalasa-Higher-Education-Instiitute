@extends('layouts.app')

@section('title', 'System Users')
@section('page-title', 'System Users')

@section('content')

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">System Users</h5>

            <a href="{{ route('admin.system-users.create') }}" class="btn btn-primary">
                Add User
            </a>

        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">

                <table class="table table-bordered align-middle">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Custom ID</th>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>User</th>
                            <th>Status</th>
                            <th width="180">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($systemUsers as $systemUser)
                            @continue(strtolower($systemUser->user?->email ?? '') === 'admin@nexorait.lk')

                            <tr>
                                <td>{{ $systemUser->id }}</td>
                                <td>{{ $systemUser->custom_id }}</td>
                                <td>{{ $systemUser->full_name }}</td>
                                <td>{{ $systemUser->mobile }}</td>
                                <td>{{ $systemUser->user?->name }}</td>
                                <td>
                                    @if($systemUser->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-1">
                                    <a href="{{ route('admin.system-users.show', $systemUser) }}" class="btn btn-sm btn-info">
                                        View
                                    </a>

                                    <a href="{{ route('admin.system-users.edit', $systemUser) }}"
                                        class="btn btn-sm btn-warning">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.system-users.destroy', $systemUser) }}" method="POST"
                                        onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    No users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $systemUsers->links() }}
            </div>

        </div>

    </div>

@endsection