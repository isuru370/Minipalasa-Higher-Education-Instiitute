@extends('layouts.app')

@section('title', 'Edit Admission')

@section('content')

<div class="container py-4">

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-4">

            <h3 class="fw-bold mb-4">
                Edit Admission
            </h3>

            <form action="{{ route('admin.admissions.update', $admission) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control rounded-4"
                           value="{{ old('name', $admission->name) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Amount
                    </label>

                    <input type="number"
                           step="0.01"
                           name="amount"
                           class="form-control rounded-4"
                           value="{{ old('amount', $admission->amount) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Note
                    </label>

                    <textarea name="note"
                              rows="4"
                              class="form-control rounded-4">{{ old('note', $admission->note) }}</textarea>
                </div>

                <div class="form-check mb-4">

                    <input type="checkbox"
                           name="is_active"
                           value="1"
                           class="form-check-input"
                           {{ $admission->is_active ? 'checked' : '' }}>

                    <label class="form-check-label">
                        Active
                    </label>

                </div>

                <button class="btn btn-warning rounded-pill px-4">
                    Update Admission
                </button>

            </form>

        </div>

    </div>

</div>

@endsection