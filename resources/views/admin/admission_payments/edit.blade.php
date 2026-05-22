@extends('layouts.app')

@section('title', 'Edit Admission Payment')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">
                Edit Admission Payment
            </h3>

            <form action="{{ route('admin.admission-payments.update', $admissionPayment) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           name="amount"
                           value="{{ $admissionPayment->amount }}"
                           class="form-control rounded-4">

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Payment Method
                    </label>

                    <select name="payment_method"
                            class="form-select rounded-4">

                        <option value="cash"
                            {{ $admissionPayment->payment_method == 'cash' ? 'selected' : '' }}>
                            Cash
                        </option>

                        <option value="card"
                            {{ $admissionPayment->payment_method == 'card' ? 'selected' : '' }}>
                            Card
                        </option>

                        <option value="bank"
                            {{ $admissionPayment->payment_method == 'bank' ? 'selected' : '' }}>
                            Bank
                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Note
                    </label>

                    <textarea name="note"
                              rows="4"
                              class="form-control rounded-4">{{ $admissionPayment->note }}</textarea>

                </div>

                <div class="form-check mb-4">

                    <input type="checkbox"
                           name="status"
                           value="1"
                           class="form-check-input"
                           {{ $admissionPayment->status ? 'checked' : '' }}>

                    <label class="form-check-label">
                        Paid
                    </label>

                </div>

                <button class="btn btn-warning rounded-pill px-4">
                    Update Payment
                </button>

            </form>

        </div>

    </div>

</div>

@endsection