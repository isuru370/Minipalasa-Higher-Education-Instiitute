@extends('layouts.app')

@section('title', 'Admission Payments')
@section('page-title', 'Admission Payments')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Admission Payments</h3>
            <p class="text-muted mb-0">
                Manage student admission payments
            </p>
        </div>

        <a href="{{ route('admin.admission-payments.create') }}"
           class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i>
            Add Payment
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.admission-payments.index') }}"
                  class="mb-4">

                <div class="row g-3">

                    <div class="col-md-8">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control rounded-4"
                               placeholder="Search receipt / student / admission">
                    </div>

                    <div class="col-md-2">
                        <select name="status"
                                class="form-select rounded-4">

                            <option value="">All Status</option>

                            <option value="1"
                                {{ request('status') == '1' ? 'selected' : '' }}>
                                Paid
                            </option>

                            <option value="0"
                                {{ request('status') == '0' ? 'selected' : '' }}>
                                Cancelled
                            </option>

                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-dark rounded-4 w-100">
                            Search
                        </button>
                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Receipt</th>
                            <th>Student</th>
                            <th>Admission</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Status</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($payments as $payment)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $payment->receipt_number }}
                                </td>

                                <td>
                                    {{ $payment->student->initial_name ?? '-' }}
                                </td>

                                <td>
                                    {{ $payment->admission->name ?? '-' }}
                                </td>

                                <td>
                                    Rs. {{ number_format($payment->amount, 2) }}
                                </td>

                                <td>
                                    {{ ucfirst($payment->payment_method) }}
                                </td>

                                <td>
                                    @if($payment->status)
                                        <span class="badge bg-success">
                                            Paid
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Cancelled
                                        </span>
                                    @endif
                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.admission-payments.show', $payment) }}"
                                           class="btn btn-sm btn-info rounded-pill">
                                            View
                                        </a>

                                        <a href="{{ route('admin.admission-payments.edit', $payment) }}"
                                           class="btn btn-sm btn-warning rounded-pill">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.admission-payments.destroy', $payment) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Delete payment?')"
                                                    class="btn btn-sm btn-danger rounded-pill">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8"
                                    class="text-center py-5 text-muted">
                                    No payments found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                {{ $payments->links() }}
            </div>

        </div>

    </div>

</div>

@endsection