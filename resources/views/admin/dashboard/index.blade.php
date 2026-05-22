@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .dashboard-page {
        animation: fadeIn .4s ease;
    }

    .hero-card {
        position: relative;
        overflow: hidden;
        border-radius: 32px;
        padding: 2rem;
        background: linear-gradient(135deg, #2563eb, #1d4ed8, #1e40af);
        box-shadow: 0 20px 45px rgba(37, 99, 235, .25);
        color: #fff;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        width: 280px;
        height: 280px;
        background: rgba(255,255,255,.08);
        border-radius: 50%;
        top: -100px;
        right: -80px;
    }

    .hero-card::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 180px;
        background: rgba(255,255,255,.06);
        border-radius: 50%;
        bottom: -60px;
        left: -40px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .7rem 1rem;
        border-radius: 14px;
        background: rgba(255,255,255,.12);
        border: 1px solid rgba(255,255,255,.08);
        backdrop-filter: blur(10px);
        font-size: .85rem;
        font-weight: 600;
    }

    .dashboard-card {
        background: #fff;
        border-radius: 28px;
        border: 1px solid #eef2f7;
        box-shadow: 0 10px 30px rgba(15, 23, 42, .05);
        overflow: hidden;
        transition: .25s ease;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
    }

    .stat-card {
        padding: 1.4rem;
        height: 100%;
    }

    .stat-icon {
        width: 62px;
        height: 62px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        flex-shrink: 0;
    }

    .bg-primary-soft { background: linear-gradient(135deg, #2563eb, #3b82f6); }
    .bg-success-soft { background: linear-gradient(135deg, #10b981, #34d399); }
    .bg-warning-soft { background: linear-gradient(135deg, #f59e0b, #fbbf24); }
    .bg-danger-soft  { background: linear-gradient(135deg, #ef4444, #f87171); }
    .bg-dark-soft    { background: linear-gradient(135deg, #0f172a, #1e293b); }

    .quick-action-btn {
        border-radius: 20px;
        padding: 1rem 1.2rem;
        font-weight: 700;
        border: none;
        transition: .25s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: .7rem;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
    }

    .summary-box {
        border-radius: 24px;
        padding: 1.4rem;
        background: #f8fafc;
        border: 1px solid #eef2f7;
        text-align: center;
        height: 100%;
    }

    .summary-box h2 {
        font-weight: 800;
        margin-bottom: .3rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: #0f172a;
    }

    .text-light-soft {
        color: rgba(255,255,255,.78);
    }

    .mini-table thead th {
        background: #f8fafc;
        color: #475569;
        font-size: .8rem;
        text-transform: uppercase;
        letter-spacing: .04em;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .mini-table td {
        vertical-align: middle;
    }

    .badge-soft {
        padding: .45rem .75rem;
        border-radius: 999px;
        font-weight: 700;
        font-size: .78rem;
    }

    .badge-low {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-good {
        background: #dcfce7;
        color: #166534;
    }

    @media(max-width: 768px) {
        .hero-card {
            padding: 1.5rem;
            border-radius: 26px;
        }

        .dashboard-card {
            border-radius: 24px;
        }

        .stat-card {
            padding: 1.2rem;
        }
    }
</style>
@endpush

@section('content')
    @php
        $greeting = 'Good Evening 🌙';

        if (now()->hour < 12) {
            $greeting = 'Good Morning 👋';
        } elseif (now()->hour < 17) {
            $greeting = 'Good Afternoon ☀️';
        }
    @endphp

    <div class="container-fluid py-4 dashboard-page">

        {{-- HERO --}}
        <div class="hero-card mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative">
                <div>
                    <div class="mb-3">
                        <span class="hero-badge">
                            <i class="fas fa-sparkles"></i>
                            {{ $greeting }}
                        </span>
                    </div>

                    <h2 class="fw-bold mb-2">
                        Welcome Back, {{ auth()->user()->name ?? 'Administrator' }}
                    </h2>

                    <p class="mb-0 text-light-soft">
                        Manage students, payments, attendance, classes, and ID cards from one premium dashboard.
                    </p>
                </div>

                <div class="text-end">
                    <div class="hero-badge mb-2">
                        <i class="fas fa-calendar-alt"></i>
                        {{ now()->format('d M Y') }}
                    </div>

                    <div class="hero-badge">
                        <i class="fas fa-clock"></i>
                        {{ now()->format('h:i A') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- ALERT --}}
        @if($showTemporaryIdCardWarning)
            <div class="alert alert-warning border-0 shadow-sm rounded-4">
                <strong>Warning!</strong> Temporary ID cards are running low.
                Remaining stock: <b>{{ $temporaryIdCardPendingCount }}</b>
            </div>
        @endif

        {{-- STATS --}}
        <div class="row g-4 mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-semibold">Total Students</small>
                            <h2 class="fw-bold mt-2 mb-0">{{ $studentsCount }}</h2>
                        </div>
                        <div class="stat-icon bg-primary-soft">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-semibold">Total Teachers</small>
                            <h2 class="fw-bold mt-2 mb-0">{{ $teachersCount }}</h2>
                        </div>
                        <div class="stat-icon bg-success-soft">
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-semibold">Running Classes</small>
                            <h2 class="fw-bold mt-2 mb-0">{{ $classesCount }}</h2>
                        </div>
                        <div class="stat-icon bg-warning-soft">
                            <i class="fas fa-school"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="dashboard-card stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted fw-semibold">Today's Income</small>
                            <h3 class="fw-bold mt-2 mb-0 text-success">
                                Rs. {{ number_format($todayIncome, 2) }}
                            </h3>
                        </div>
                        <div class="stat-icon bg-danger-soft">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECOND ROW --}}
        <div class="row g-4">
            <div class="col-xl-4">
                <div class="dashboard-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="section-title mb-0">Quick Actions</h5>
                        <span class="badge bg-primary rounded-pill">Actions</span>
                    </div>

                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.students.create') }}" class="btn quick-action-btn text-white bg-primary-soft">
                            <i class="fas fa-user-plus"></i>
                            Add Student
                        </a>

                        <a href="{{ route('admin.payments.index') }}" class="btn quick-action-btn text-white bg-success-soft">
                            <i class="fas fa-money-check-alt"></i>
                            Add Payment
                        </a>

                        <a href="{{ route('admin.student-classes.create') }}" class="btn quick-action-btn text-dark bg-warning-soft">
                            <i class="fas fa-calendar-plus"></i>
                            Create Class
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="dashboard-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="section-title mb-0">System Overview</h5>
                        <span class="badge bg-dark rounded-pill">Live</span>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="summary-box">
                                <h2 class="text-primary">{{ $studentsCount }}</h2>
                                <p class="text-muted mb-0">Students Registered</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="summary-box">
                                <h2 class="text-success">{{ $teachersCount }}</h2>
                                <p class="text-muted mb-0">Teachers Active</p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="summary-box">
                                <h2 class="text-warning">{{ $classesCount }}</h2>
                                <p class="text-muted mb-0">Classes Running</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="dashboard-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted fw-semibold">Temporary ID Cards</small>
                            <h2 class="fw-bold mt-2 mb-3">{{ $temporaryIdCardPendingCount }}</h2>

                            @if($showTemporaryIdCardWarning)
                                <span class="badge-soft badge-low">Low Stock</span>
                            @else
                                <span class="badge-soft badge-good">Enough Stock</span>
                            @endif
                        </div>

                        <div class="stat-icon bg-dark-soft">
                            <i class="fas fa-id-card"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="dashboard-card p-4 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="section-title mb-0">Incomplete Registrations</h5>
                        <span class="badge bg-warning text-dark rounded-pill">
                            {{ $incompleteRegistrationCount }} Pending
                        </span>
                    </div>

                    <div class="table-responsive">
                        <table class="table mini-table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Custom ID</th>
                                    <th>Name</th>
                                    <th>Temporary QR</th>
                                    <th>Guardian Mobile</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($incompleteRegistrations as $card)
                                    <tr>
                                        <td>{{ $card->student->custom_id ?? '-' }}</td>
                                        <td>{{ $card->student->initial_name ?? '-' }}</td>
                                        <td>{{ $card->student->temporary_qr_code ?? '-' }}</td>
                                        <td>{{ $card->student->guardian_mobile ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No incomplete registrations found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="dashboard-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="section-title mb-0">Latest Students</h5>
                        <span class="badge bg-primary rounded-pill">Recent</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table mini-table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Custom ID</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Joined</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestStudents as $student)
                                    <tr>
                                        <td>{{ $student->custom_id ?? '-' }}</td>
                                        <td>{{ $student->initial_name ?? '-' }}</td>
                                        <td>{{ $student->guardian_mobile ?? '-' }}</td>
                                        <td>{{ optional($student->created_at)->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No students found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection