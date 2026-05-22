@extends('layouts.app')

@section('title', 'Admission Payment Details')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center mb-4">

                <h3 class="fw-bold mb-0">
                    Payment Details
                </h3>

                <a href="{{ route('admin.admission-payments.index') }}"
                   class="btn btn-dark rounded-pill">
                    Back
                </a>

            </div>

            <table class="table">

                <tr>
                    <th>Receipt Number</th>
                    <td>{{ $admissionPayment->receipt_number }}</td>
                </tr>

                <tr>
                    <th>Student</th>
                    <td>{{ $admissionPayment->student->initial_name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Admission</th>
                    <td>{{ $admissionPayment->admission->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Amount</th>
                    <td>
                        Rs. {{ number_format($admissionPayment->amount, 2) }}
                    </td>
                </tr>

                <tr>
                    <th>Payment Method</th>
                    <td>{{ ucfirst($admissionPayment->payment_method) }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($admissionPayment->status)
                            <span class="badge bg-success">
                                Paid
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Cancelled
                            </span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Collected By</th>
                    <td>{{ $admissionPayment->collectedBy->name ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Paid At</th>
                    <td>{{ $admissionPayment->paid_at }}</td>
                </tr>

                <tr>
                    <th>Note</th>
                    <td>{{ $admissionPayment->note ?? '-' }}</td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection