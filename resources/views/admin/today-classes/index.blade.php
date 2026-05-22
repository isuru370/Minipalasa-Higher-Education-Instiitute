@extends('layouts.app')

@section('title', "Today's Classes")
@section('page-title', "Today's Classes")

@section('content')
    @php
        $classCollection = collect($classes);

        $todayDate = \Carbon\Carbon::parse($today);
        $dayName = $todayDate->format('l');

        $totalClasses = $classCollection->count();

        $totalSchedules = $classCollection->sum(function ($class) {
            return $class->schedules ? $class->schedules->count() : 0;
        });

        $classesWithFee = $classCollection->filter(function ($class) {
            return $class->categoryFees && $class->categoryFees->count() > 0;
        })->count();

        $classesWithoutFee = $classCollection->filter(function ($class) {
            return !($class->categoryFees && $class->categoryFees->count() > 0);
        })->count();

        $searchValue = request('search', '');
    @endphp

    <div class="today-classes-page">

        <!-- HERO -->
        <div class="hero-card mb-4">
            <div class="hero-content">

                <div>
                    <h3 class="fw-bold mb-1">Today's Classes</h3>
                    <p class="text-muted mb-0">
                        {{ $todayDate->format('Y-m-d') }} | {{ ucfirst($dayName) }}
                    </p>
                </div>

                <div class="hero-actions">
                    <button type="button" class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-printer"></i>
                        Print
                    </button>

                    <button type="button" class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-file-earmark-excel-fill"></i>
                        Export
                    </button>
                </div>

            </div>
        </div>

        <!-- STATS -->
        <div class="row g-4 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon blue">
                        <i class="bi bi-calendar2-week-fill"></i>
                    </div>
                    <div>
                        <h3>{{ $totalClasses }}</h3>
                        <p>Classes Today</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon green">
                        <i class="bi bi-clock-fill"></i>
                    </div>
                    <div>
                        <h3>{{ $totalSchedules }}</h3>
                        <p>Total Schedules</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon orange">
                        <i class="bi bi-cash-coin"></i>
                    </div>
                    <div>
                        <h3>{{ $classesWithFee }}</h3>
                        <p>Fee Ready</p>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="stats-card">
                    <div class="stats-icon red">
                        <i class="bi bi-exclamation-circle-fill"></i>
                    </div>
                    <div>
                        <h3>{{ $classesWithoutFee }}</h3>
                        <p>No Fee Config</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- MAIN CARD -->
        <div class="main-card">

            <!-- HEADER -->
            <div class="main-card-header">

                <div>
                    <h4>Today's Classes</h4>
                    <p>
                        {{ $todayDate->format('Y-m-d') }} | {{ ucfirst($dayName) }}
                    </p>
                </div>

                <div class="header-buttons">

                    <button type="button" class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-printer"></i>
                        Print
                    </button>

                    <button type="button" class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-file-earmark-excel-fill"></i>
                        Export
                    </button>

                </div>

            </div>

            <!-- SEARCH -->
            <div class="search-card">

                <form method="GET" action="{{ url()->current() }}">
                    <div class="row g-3">

                        <div class="col-lg-10">
                            <div class="search-input-wrapper">
                                <i class="bi bi-search"></i>
                                <input type="text" name="search" class="form-control custom-input"
                                    placeholder="Search class, grade, subject, teacher, category..."
                                    value="{{ $searchValue }}">
                            </div>
                        </div>

                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-primary w-100 custom-btn">
                                Search
                            </button>
                        </div>

                    </div>

                    @if($searchValue !== '')
                        <div class="mt-3">
                            <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary custom-btn">
                                Clear
                            </a>
                        </div>
                    @endif
                </form>

            </div>

            @forelse($classCollection as $class)
                @php
                    $schedules = $class->schedules ?? collect();
                    $categoryFees = $class->categoryFees ?? collect();

                    $firstFee = $categoryFees->first();
                @endphp

                <div class="class-card mb-4">

                    <div class="class-card-header">

                        <div>
                            <h5 class="mb-1 fw-bold">{{ $class->class_name }}</h5>

                            <div class="meta-line">
                                Grade: {{ optional($class->grade)->grade_name ?? '-' }}
                                <span class="meta-separator">|</span>
                                Subject: {{ optional($class->subject)->subject_name ?? '-' }}
                                <span class="meta-separator">|</span>
                                Teacher: {{ optional($class->teacher)->initials ?? '-' }}
                            </div>
                        </div>

                        <div class="class-badges">
                            <span class="badge bg-primary custom-badge">
                                {{ $schedules->count() }} Schedules
                            </span>

                            <span class="badge bg-success custom-badge">
                                {{ $categoryFees->count() }} Fees
                            </span>

                            @if($class->is_active)
                                <span class="badge bg-success custom-badge">Active</span>
                            @else
                                <span class="badge bg-secondary custom-badge">Inactive</span>
                            @endif
                        </div>

                    </div>

                    <div class="table-responsive">
                        <table class="table custom-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Class</th>
                                    <th>Category Fees</th>
                                    <th>Teacher</th>
                                    <th>Hall</th>
                                    <th class="text-end" width="220">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">
                                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                -
                                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="fw-bold">
                                                {{ $class->class_name }}
                                            </div>
                                            <small class="text-muted">
                                                {{ optional($class->grade)->grade_name ?? '-' }}
                                                /
                                                {{ optional($class->subject)->subject_name ?? '-' }}
                                            </small>
                                        </td>

                                        <td>
                                            @forelse($categoryFees as $fee)
                                                <span class="fee-pill">
                                                    {{ optional($fee->category)->category_name ?? '-' }}
                                                    · Rs. {{ number_format($fee->fee, 2) }}
                                                    · Fee ID: {{ $fee->id }}
                                                </span>
                                                <br>
                                            @empty
                                                <span class="text-muted">No Category Fees</span>
                                            @endforelse
                                        </td>

                                        <td>
                                            <div class="fw-semibold">
                                                {{ optional($class->teacher)->initials ?? '-' }}
                                            </div>
                                        </td>

                                        <td>
                                            <span class="fw-semibold">
                                                {{ optional($schedule->hall)->hall_name ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="action-buttons">

                                                @if($firstFee)
                                                                            <a href="{{ route('admin.attendance.index', [
                                                        'class_schedule_id' => $schedule->id,
                                                        'student_class_id' => $class->id,
                                                        'class_category_fee_id' => $firstFee->id,
                                                    ]) }}" class="action-btn view-btn" title="Mark Attendance">
                                                                                <i class="bi bi-check2-square"></i>
                                                                            </a>
                                                @else
                                                    <button type="button" class="action-btn disabled-btn" disabled
                                                        title="No Category Fee">
                                                        <i class="bi bi-check2-square"></i>
                                                    </button>
                                                @endif

                                                <form action="{{ route('admin.class-schedules.statusUpdate', $schedule) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="action-btn complete-btn" title="Complete">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">
                                            <div class="empty-state">
                                                <i class="bi bi-calendar-x"></i>
                                                <h5>No Schedules Found</h5>
                                                <p>No classes are available for today</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            @empty
                <div class="alert alert-info border-0 shadow-sm">
                    <i class="bi bi-info-circle-fill me-2"></i>
                    No classes today.
                </div>
            @endforelse

        </div>
    </div>
@endsection

@push('styles')
    <style>
        .today-classes-page {
            animation: fadeIn .4s ease;
        }

        .hero-card,
        .main-card,
        .stats-card,
        .class-card {
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .04);
            border: 1px solid #eef2f7;
        }

        .hero-card,
        .main-card {
            padding: 1.5rem;
        }

        .hero-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-actions {
            display: flex;
            gap: .7rem;
            flex-wrap: wrap;
        }

        .stats-card {
            padding: 1.5rem;
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .blue {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
        }

        .green {
            background: linear-gradient(135deg, #10b981, #34d399);
        }

        .orange {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
        }

        .red {
            background: linear-gradient(135deg, #ef4444, #f87171);
        }

        .stats-card h3 {
            margin: 0;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .stats-card p {
            margin: 0;
            color: #64748b;
        }

        .main-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .main-card-header h4 {
            margin: 0;
            font-weight: 700;
        }

        .main-card-header p {
            margin: 0;
            color: #64748b;
        }

        .header-buttons {
            display: flex;
            gap: .7rem;
            flex-wrap: wrap;
        }

        .custom-btn {
            border-radius: 14px;
            padding: .7rem 1.2rem;
            font-weight: 600;
            border: none;
            transition: .2s ease;
        }

        .custom-btn:hover {
            transform: translateY(-2px);
        }

        .search-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .search-input-wrapper {
            position: relative;
        }

        .search-input-wrapper i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #64748b;
        }

        .custom-input {
            border-radius: 14px !important;
            border: 1px solid #e2e8f0;
            min-height: 48px;
            padding-left: 42px;
        }

        .custom-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
        }

        .class-card {
            padding: 1.25rem;
        }

        .class-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .meta-line {
            color: #64748b;
            font-size: .92rem;
        }

        .meta-separator {
            margin: 0 .35rem;
        }

        .class-badges {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .custom-table thead th {
            border: none;
            background: #f8fafc;
            color: #475569;
            font-size: .82rem;
            text-transform: uppercase;
            padding: 1rem;
            white-space: nowrap;
        }

        .custom-table tbody tr {
            transition: .2s ease;
        }

        .custom-table tbody tr:hover {
            background: #f8fafc;
        }

        .custom-table tbody td {
            padding: 1rem;
            border-color: #f1f5f9;
            vertical-align: middle;
        }

        .badge {
            border-radius: 10px;
            padding: .5rem .7rem;
            font-size: .75rem;
        }

        .custom-badge {
            border-radius: 10px;
            padding: .5rem .7rem;
            font-size: .75rem;
        }

        .fee-pill {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #dbeafe;
            border-radius: 999px;
            padding: .35rem .7rem;
            font-size: .78rem;
            margin-bottom: .4rem;
        }

        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: .5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: .2s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .view-btn {
            background: #eff6ff;
            color: #2563eb;
        }

        .complete-btn {
            background: #ecfdf5;
            color: #10b981;
        }

        .disabled-btn {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .empty-state {
            text-align: center;
        }

        .empty-state i {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            font-weight: 700;
        }

        @media (max-width: 768px) {

            .hero-content,
            .main-card-header,
            .class-card-header {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-actions,
            .header-buttons,
            .class-badges {
                width: 100%;
            }

            .hero-actions .btn,
            .header-buttons .btn {
                flex: 1;
            }
        }
    </style>
@endpush