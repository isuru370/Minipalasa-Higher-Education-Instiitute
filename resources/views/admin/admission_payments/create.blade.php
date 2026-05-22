@extends('layouts.app')

@section('title', 'Create Admission Payment')

@section('content')

    <div class="container py-4">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h3 class="fw-bold mb-4">
                    Create Admission Payment
                </h3>

                <form action="{{ route('admin.admission-payments.store') }}" method="POST">

                    @csrf

                    <div class="row">

                        {{-- STUDENT --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Student
                            </label>

                            <select name="student_id" class="form-select rounded-4" required>

                                <option value="">Select Student</option>

                                @foreach($students as $student)

                                    <option value="{{ $student->id }}">

                                        {{ $student->custom_id }}
                                        -
                                        {{ $student->initial_name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        {{-- ADMISSION --}}
                        <div class="col-md-6 mb-3">

                            <label class="form-label fw-semibold">
                                Admission
                            </label>

                            <select name="admission_id" id="admissionSelect" class="form-select rounded-4" required>

                                <option value="">
                                    Select Admission
                                </option>

                                @foreach($admissions as $admission)

                                    <option value="{{ $admission->id }}" data-amount="{{ $admission->amount }}">

                                        {{ $admission->name }}
                                        -
                                        Rs. {{ number_format($admission->amount, 2) }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>

                    {{-- AMOUNT --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Amount
                        </label>

                        <input type="number" step="0.01" name="amount" id="amountInput" class="form-control rounded-4"
                            readonly>

                    </div>

                    {{-- PAYMENT METHOD --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Payment Method
                        </label>

                        <select name="payment_method" class="form-select rounded-4">

                            <option value="cash">
                                Cash
                            </option>

                            <option value="card">
                                Card
                            </option>

                            <option value="bank">
                                Bank
                            </option>

                        </select>

                    </div>

                    {{-- NOTE --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Note
                        </label>

                        <textarea name="note" rows="4" class="form-control rounded-4"></textarea>

                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select name="status" class="form-select rounded-4">
                            <option value="pending">Pending</option>
                            <option value="paid" selected>Paid</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="refunded">Refunded</option>
                        </select>

                    </div>

                    <button class="btn btn-primary rounded-pill px-4">
                        Save Payment
                    </button>

                </form>

            </div>

        </div>

    </div>

    {{-- SCRIPT --}}
    <script>

        const admissionSelect =
            document.getElementById('admissionSelect');

        const amountInput =
            document.getElementById('amountInput');

        admissionSelect.addEventListener('change', function () {

            const selectedOption =
                this.options[this.selectedIndex];

            const amount =
                selectedOption.getAttribute('data-amount');

            amountInput.value = amount ?? '';

        });

    </script>

@endsection