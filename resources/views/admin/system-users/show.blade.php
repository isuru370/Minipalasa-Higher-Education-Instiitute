@extends('layouts.app')

@section('title', 'View System User')
@section('page-title', 'View System User')

@section('content')

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <h5 class="mb-0">System User Details</h5>

        <a href="{{ route('admin.system-users.edit', $systemUser) }}"
            class="btn btn-warning">
            Edit
        </a>

    </div>

    <div class="card-body">

        <div class="row g-3">

            <div class="col-md-4">
                <strong>Custom ID:</strong>
                <div>{{ $systemUser->custom_id }}</div>
            </div>

            <div class="col-md-4">
                <strong>Full Name:</strong>
                <div>{{ $systemUser->full_name }}</div>
            </div>

            <div class="col-md-4">
                <strong>Mobile:</strong>
                <div>{{ $systemUser->mobile }}</div>
            </div>

            <div class="col-md-4">
                <strong>NIC:</strong>
                <div>{{ $systemUser->nic }}</div>
            </div>

            <div class="col-md-4">
                <strong>Birthday:</strong>
                <div>{{ optional($systemUser->bday)->format('Y-m-d') }}</div>
            </div>

            <div class="col-md-4">
                <strong>Gender:</strong>
                <div>{{ ucfirst($systemUser->gender) }}</div>
            </div>

            <div class="col-md-4">
                <strong>User:</strong>
                <div>{{ $systemUser->user?->name }}</div>
            </div>

            <div class="col-md-4">
                <strong>Status:</strong>

                <div>
                    @if($systemUser->is_active)
                        <span class="badge bg-success">
                            Active
                        </span>
                    @else
                        <span class="badge bg-danger">
                            Inactive
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <strong>Address:</strong>

                <div>
                    {{ $systemUser->address1 }}
                    {{ $systemUser->address2 }}
                    {{ $systemUser->address3 }}
                </div>
            </div>

            <div class="col-md-12">
                <strong>Note:</strong>

                <div>
                    {{ $systemUser->note }}
                </div>
            </div>

        </div>

    </div>

</div>

@endsection