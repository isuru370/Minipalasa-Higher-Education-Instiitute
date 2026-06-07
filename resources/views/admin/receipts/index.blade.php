@extends('layouts.app')

@section('title', 'Receipts - ' . config('app.name', 'EDU NEXORA'))
@section('page-title', 'Receipts')

@section('content')

    <div class="container-fluid">
        {{-- Summary Cards --}}
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">
                            Total Receipts
                        </h6>

                        <h3 class="mb-0">
                            {{ number_format($totalReceipts ?? 0) }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="text-muted mb-1">
                            Total Amount
                        </h6>

                        <h3 class="mb-0">
                            Rs. {{ number_format($totalAmount ?? 0, 2) }}
                        </h3>
                    </div>
                </div>
            </div>

        </div>

        {{-- Filters --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">

                <form method="GET" action="{{ route('admin.receipts.index') }}">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">
                                Receipt Number
                            </label>

                            <input type="text" name="receipt_number" class="form-control"
                                value="{{ request('receipt_number') }}" placeholder="Search receipt number">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">
                                Type
                            </label>

                            <select name="type" class="form-select">

                                <option value="">
                                    All Types
                                </option>

                                <option value="Student Payment" @selected(request('type') === 'Student Payment')>
                                    Student Payment
                                </option>

                                <option value="Admission Payment" @selected(request('type') === 'Admission Payment')>
                                    Admission Payment
                                </option>

                                <option value="Extra Income" @selected(request('type') === 'Extra Income')>
                                    Extra Income
                                </option>

                            </select>
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">
                                Date From
                            </label>

                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>

                        <div class="col-md-2">
                            <label class="form-label">
                                Date To
                            </label>

                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>

                        <div class="col-md-2 d-flex align-items-end">

                            <button type="submit" class="btn btn-primary w-100">

                                Search

                            </button>

                        </div>

                    </div>

                </form>

            </div>
        </div>

        {{-- Receipt Table --}}
        <div class="card shadow-sm border-0">

            <div class="card-header bg-white">
                <h5 class="mb-0">
                    Receipt List
                </h5>
            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th width="180">
                                    Receipt No
                                </th>

                                <th>
                                    Type
                                </th>

                                <th class="text-end">
                                    Amount
                                </th>

                                <th width="180">
                                    Date
                                </th>

                                <th width="120">
                                    Actions
                                </th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($receipts as $receipt)

                                <tr>

                                    <td>

                                        <a href="{{ $receipt['url'] }}" class="fw-semibold text-decoration-none">

                                            {{ $receipt['receipt_number'] }}

                                        </a>

                                    </td>

                                    <td>

                                        @if($receipt['type'] === 'Student Payment')

                                            <span class="badge bg-primary">
                                                Student Payment
                                            </span>

                                        @elseif($receipt['type'] === 'Admission Payment')

                                            <span class="badge bg-success">
                                                Admission Payment
                                            </span>

                                        @else

                                            <span class="badge bg-warning text-dark">
                                                Extra Income
                                            </span>

                                        @endif

                                    </td>

                                    <td class="text-end">

                                        Rs.
                                        {{ number_format($receipt['amount'], 2) }}

                                    </td>

                                    <td>

                                        {{ \Carbon\Carbon::parse($receipt['date'])->format('Y-m-d H:i') }}

                                    </td>

                                    <td>

                                        <a href="{{ $receipt['url'] }}" class="btn btn-sm btn-outline-primary">

                                            View

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="5" class="text-center py-5 text-muted">

                                        No receipts found.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

@endsection