@extends('layouts.app')

@section('title', 'Admission Details')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3 class="fw-bold mb-0">
                    Admission Details
                </h3>

                <a href="{{ route('admin.admissions.index') }}"
                   class="btn btn-dark rounded-pill">
                    Back
                </a>

            </div>

            <table class="table">

                <tr>
                    <th>Name</th>
                    <td>{{ $admission->name }}</td>
                </tr>

                <tr>
                    <th>Amount</th>
                    <td>
                        Rs. {{ number_format($admission->amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($admission->is_active)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactive
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Note</th>
                    <td>{{ $admission->note ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $admission->created_at }}</td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection