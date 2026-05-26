@extends('layouts.app')

@section('title', 'Monthly Payment Report')
@section('page-title', 'Monthly Payment Report')

@section('content')

    {{-- ========================================= --}}
    {{-- Teacher Salary Report Section --}}
    {{-- ========================================= --}}
    <div class="card shadow-sm border-0">

        {{-- Card Header --}}
        <div class="card-header bg-white border-bottom">

            <div class="d-flex justify-content-between align-items-center">

                <div>
                    <h2 class="mb-1 fw-bold">
                        Teacher Salary Report
                    </h2>

                    <p class="text-muted mb-0">
                        Filter and download monthly teacher salary reports
                    </p>
                </div>

            </div>

        </div>

        {{-- Card Body --}}
        <div class="card-body">

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.monthly-report.index') }}">

                <div class="row align-items-end g-3">

                    {{-- Year --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Year
                        </label>

                        <select name="year" class="form-select">

                            @for ($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>

                                    {{ $y }}

                                </option>
                            @endfor

                        </select>
                    </div>

                    {{-- Month --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">
                            Month
                        </label>

                        <select name="month" class="form-select">

                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>

                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}

                                </option>
                            @endfor

                        </select>
                    </div>

                    {{-- Filter Button --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Filter Report
                        </button>
                    </div>

                </div>

            </form>

            {{-- Divider --}}
            <hr class="my-4">

            {{-- Download Buttons --}}
            <div class="d-flex gap-2">

                {{-- Excel Download --}}
                <a href="{{ route('admin.teacher.salary.report.excel', [
        'year' => request('year', now()->year),
        'month' => request('month', now()->month),
    ]) }}" class="btn btn-success">

                    <i class="fas fa-file-excel me-1"></i>
                    Download Excel
                </a>

                {{-- PDF Download --}}
                <a href="{{ route('admin.teacher.salary.report.pdf', [
        'year' => request('year', now()->year),
        'month' => request('month', now()->month),
    ]) }}" class="btn btn-danger">

                    <i class="fas fa-file-pdf me-1"></i>
                    Download PDF
                </a>

            </div>

        </div>

    </div>

    {{-- ========================================= --}}
    {{-- Teacher Salary Slip Section --}}
    {{-- ========================================= --}}
    <div class="card shadow-sm border-0">

        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1 fw-bold">
                        Teacher Salary Slip Report
                    </h2>

                    <p class="text-muted mb-0">
                        Filter and download monthly teacher salary reports
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body">

            {{-- Filter Form --}}
            <form method="GET" action="{{ route('admin.monthly-report.index') }}">

                <div class="row align-items-end g-3">

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Year</label>
                        <select name="year" class="form-select">
                            @for ($y = now()->year; $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ request('year', now()->year) == $y ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Month</label>
                        <select name="month" class="form-select">
                            @for ($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ request('month', now()->month) == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create()->month($m)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Teacher</label>
                        <select name="teacher_id" class="form-select">
                            <option value="">-- Select Teacher --</option>

                            @foreach ($teachers as $teacherItem)
                                <option value="{{ $teacherItem->id }}" {{ request('teacher_id') == $teacherItem->id ? 'selected' : '' }}>
                                    {{ $teacherItem->custom_id }} - {{ $teacherItem->initials }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            Filter Report
                        </button>
                    </div>

                </div>

            </form>

            <hr class="my-4">

            <div class="d-flex gap-2">

                @php
                    $teacherId = request('teacher_id');
                    $year = request('year', now()->year);
                    $month = request('month', now()->month);
                @endphp

                @if($teacherId)
                            <a href="{{ route('admin.teacher-salaries.slip', [
                        'teacher' => $teacherId,
                        'year' => $year,
                        'month' => $month,
                    ]) }}?autoPrint=true" target="_blank" class="btn btn-danger">
                                <i class="fas fa-file-pdf me-1"></i>
                                Print Salary Slip
                            </a>
                @endif

            </div>

        </div>
    </div>

@endsection