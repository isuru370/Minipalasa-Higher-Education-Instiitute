@extends('layouts.app')

@section('title', 'Generate Student ID')
@section('page-title', 'Generate Student ID')

@section('breadcrumb')
    <li class="breadcrumb-item active">Generate Student ID</li>
@endsection

@push('styles')
    <style>
        @font-face {
            font-family: 'Monbaiti';
            src: url('{{ asset('fonts/monbaiti.ttf') }}') format('truetype');
            font-weight: normal;
            font-style: normal;
            font-display: swap;
        }

        :root {
            --id-blue: #0f4bb5;
            --id-blue-dark: #123a8a;
            --id-green: #17a34a;
            --id-teal: #0f766e;
            --id-gold: #d4af37;
            --id-bg: #f6f9ff;
            --id-text: #0f172a;
            --id-muted: #64748b;
            --id-border: #e5edf7;
        }

        .student-id-page {
            animation: fadeIn .35s ease;
        }

        /* Hero Card */
        .hero-card {
            position: relative;
            overflow: hidden;
            border-radius: 30px;
            padding: 1.75rem;
            background: linear-gradient(135deg, #0f172a 0%, #0f4bb5 52%, #0f766e 100%);
            color: #fff;
            box-shadow: 0 18px 40px rgba(15, 23, 42, .18);
        }

        .hero-card::before,
        .hero-card::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-card::before {
            width: 280px;
            height: 280px;
            background: rgba(255, 255, 255, .08);
            top: -120px;
            right: -90px;
        }

        .hero-card::after {
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, .06);
            bottom: -70px;
            left: -70px;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            padding: .55rem .95rem;
            border-radius: 999px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .08);
            font-weight: 700;
            font-size: .84rem;
            backdrop-filter: blur(8px);
        }

        /* Premium Card */
        .premium-card {
            background: #fff;
            border-radius: 28px;
            border: 1px solid #edf2f7;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .05);
            overflow: hidden;
        }

        .search-card {
            padding: 1.4rem;
        }

        .custom-input {
            height: 52px;
            border-radius: 16px;
            border: 1px solid #dbe3ee;
            box-shadow: none;
        }

        .custom-input:focus {
            border-color: var(--id-blue);
            box-shadow: 0 0 0 4px rgba(15, 75, 181, .08);
        }

        .custom-btn {
            border-radius: 16px;
            height: 50px;
            padding: 0 1.2rem;
            font-weight: 700;
            transition: .2s ease;
        }

        .custom-btn:hover {
            transform: translateY(-2px);
        }

        .bulk-actions {
            background: #fff;
            padding: 1.2rem 1.3rem;
            border-radius: 26px;
            border: 1px solid #edf2f7;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .04);
        }

        /* Student Card */
        .student-card {
            position: relative;
            transition: .25s ease;
        }

        .student-card:hover {
            transform: translateY(-5px);
        }

        .student-card.selected .premium-student-card {
            border-color: var(--id-blue);
            box-shadow: 0 18px 35px rgba(15, 75, 181, .12);
        }

        .premium-student-card {
            background: #fff;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid #edf2f7;
            box-shadow: 0 10px 25px rgba(15, 23, 42, .05);
            transition: .2s ease;
            height: 100%;
        }

        .student-top {
            padding: .95rem 1.1rem;
            border-bottom: 1px solid #f1f5f9;
            background: linear-gradient(180deg, #ffffff 0%, #fbfdff 100%);
        }

        .student-id-badge {
            background: rgba(15, 75, 181, .08);
            color: var(--id-blue);
            border-radius: 999px;
            padding: .42rem .9rem;
            font-weight: 800;
            font-size: .82rem;
            letter-spacing: .4px;
        }

        /* ID Card Container - Exact Dimensions */
        .id-card-preview-wrap {
            padding: 1.5rem;
            display: flex;
            justify-content: center;
            background: linear-gradient(180deg, #f8fbff 0%, #f4f8fd 100%);
        }

        /* 3.375" x 2.125" = 85.725mm x 53.975mm */
        .student-id-card {
            width: 85.725mm;
            height: 53.975mm;
            border-radius: 3.5mm;
            position: relative;
            overflow: hidden;
            background: linear-gradient(145deg, #ffffff 0%, #fafdff 30%, #eef2f8 100%);
            border: 0.5mm solid rgba(15, 75, 181, 0.15);
            box-shadow: 0 4mm 12mm rgba(2, 6, 23, 0.12);
            padding: 3mm;
            font-family: 'Monbaiti', serif !important;
            transition: transform 0.3s ease;
        }

        .student-id-card:hover {
            transform: scale(1.02);
        }

        /* Smooth Background Gradient */
        .card-bg-gradient {
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 30%, rgba(15, 75, 181, 0.04) 0%, transparent 60%),
                        radial-gradient(circle at 85% 70%, rgba(15, 118, 110, 0.04) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Background Glow Effects - Smooth */
        .card-glow {
            position: absolute;
            inset: 0;
            pointer-events: none;
            background: linear-gradient(115deg, rgba(15, 75, 181, 0.05) 0%, transparent 40%),
                        linear-gradient(245deg, rgba(23, 163, 74, 0.04) 0%, transparent 45%);
        }

        .card-watermark {
            position: absolute;
            right: -5mm;
            bottom: -3mm;
            font-size: 12mm;
            font-weight: 900;
            color: rgba(15, 75, 181, 0.05);
            letter-spacing: 1mm;
            transform: rotate(-15deg);
            user-select: none;
            pointer-events: none;
            font-family: Arial, sans-serif;
        }

        /* Card Header - Logo Only */
        .card-header-id {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 2mm;
            margin-bottom: 2.5mm;
        }

        .logo-only {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .brand-logo {
            width: 12mm;
            height: 12mm;
            object-fit: contain;
            filter: drop-shadow(0 1mm 2mm rgba(0, 0, 0, .08));
        }

        .card-pill {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2.3mm;
            font-weight: 800;
            color: #fff;
            background: linear-gradient(135deg, var(--id-blue) 0%, var(--id-teal) 100%);
            border-radius: 999px;
            padding: 1.2mm 2.5mm;
            letter-spacing: 0.3mm;
            box-shadow: 0 1mm 2mm rgba(15, 75, 181, .15);
        }

        /* Main Content Area - Expanded (no QR section) */
        .card-main-id {
            position: relative;
            z-index: 2;
            display: flex;
            gap: 3mm;
            height: calc(100% - 10mm);
        }

        /* Photo Section */
        .photo-section {
            flex-shrink: 0;
            width: 24mm;
        }

        .photo-frame {
            width: 24mm;
            height: 28mm;
            border-radius: 2.5mm;
            overflow: hidden;
            border: 0.4mm solid rgba(15, 75, 181, 0.25);
            background: #fff;
            box-shadow: 0 1mm 2.5mm rgba(15, 23, 42, .08);
        }

        .photo-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        /* Info Section - Expanded (takes remaining space) */
        .info-section {
            flex: 1;
            min-width: 0;
            padding-top: 0.5mm;
        }

        .id-number-line {
            display: inline-flex;
            align-items: baseline;
            gap: 1mm;
            flex-wrap: wrap;
        }

        .id-label {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2mm;
            font-weight: 800;
            color: var(--id-muted);
            text-transform: uppercase;
            letter-spacing: 0.2mm;
        }

        .id-value {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 4.5mm;
            line-height: 1.05;
            font-weight: 900;
            color: var(--id-blue-dark);
            word-break: break-word;
        }

        /* Student Name - UPPERCASE */
        .student-name {
            display: block;
            margin-top: 1.5mm;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 3.5mm;
            line-height: 1.15;
            font-weight: 800;
            color: #111827;
            text-transform: uppercase;
            word-break: break-word;
            letter-spacing: 0.1mm;
        }

        .details-grid {
            margin-top: 2mm;
            padding-top: 1.5mm;
            border-top: 0.3mm dashed rgba(100, 116, 139, 0.25);
        }

        .detail-row {
            margin-bottom: 1.2mm;
        }

        .detail-label {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2mm;
            font-weight: 800;
            color: var(--id-green);
            letter-spacing: 0.15mm;
            text-transform: uppercase;
            display: inline-block;
            background: rgba(23, 163, 74, 0.08);
            padding: 0.3mm 1mm;
            border-radius: 1mm;
        }

        .detail-value {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2.5mm;
            line-height: 1.25;
            color: #1f2937;
            margin-top: 0.4mm;
            word-wrap: break-word;
        }

        /* Card Footer - Clean Design */
        .id-footer-id {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 2mm;
            padding: 1.5mm 3mm;
            background: transparent;
            color: var(--id-blue-dark);
        }

        .footer-line {
            display: flex;
            align-items: center;
            gap: 1.2mm;
        }

        .footer-mini-logo {
            width: 5mm;
            height: 5mm;
            object-fit: contain;
            filter: drop-shadow(0 1mm 1mm rgba(0, 0, 0, .08));
        }

        .footer-text {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2.2mm;
            font-weight: 800;
            letter-spacing: 0.2mm;
            text-transform: uppercase;
            color: var(--id-blue-dark);
        }

        .footer-right {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 2mm;
            font-weight: 700;
            opacity: 0.8;
            color: var(--id-muted);
        }

        /* Download Button */
        .download-btn {
            width: 100%;
            height: 48px;
            border-radius: 16px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--id-blue), #3b82f6);
            border: none;
            transition: all 0.3s ease;
        }

        .download-btn:hover {
            opacity: 0.95;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 75, 181, 0.3);
        }

        /* Pagination */
        .pagination .page-link {
            border-radius: 14px !important;
            margin: 0 4px;
            border: none;
            color: #0f172a;
            min-width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(15, 23, 42, .05);
        }

        .pagination .active .page-link {
            background: var(--id-blue);
            color: #fff;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-card {
                padding: 1.4rem;
                border-radius: 24px;
            }

            .student-id-card {
                transform: scale(0.95);
                transform-origin: center top;
            }

            .id-card-preview-wrap {
                padding: 1rem;
            }
        }

        @media print {
            .sidebar, .top-navbar, .hero-card, .search-card, .bulk-actions, .download-btn, .pagination {
                display: none !important;
            }

            .student-id-card {
                box-shadow: none;
                break-inside: avoid;
                page-break-inside: avoid;
            }

            .student-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid py-4 student-id-page">

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-4">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- HERO --}}
        <div class="hero-card mb-4">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 position-relative">
                <div>
                    <div class="hero-badge mb-3">
                        <i class="fas fa-id-card"></i>
                        Student ID Management
                    </div>
                    <h2 class="fw-bold mb-2">Generate Student ID Cards</h2>
                    <p class="mb-0 text-white-50">Preview, manage and bulk download student ID cards (3.375" x 2.125")</p>
                </div>
                <div class="text-end">
                    <div class="hero-badge mb-2">
                        <i class="fas fa-users"></i>
                        {{ $students->total() }} Students
                    </div>
                    <div class="hero-badge">
                        <i class="fas fa-calendar"></i>
                        {{ now()->format('d M Y') }}
                    </div>
                </div>
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="premium-card search-card mb-4">
            <form method="GET" action="{{ url()->current() }}" class="row g-3 align-items-end">
                <div class="col-lg-8">
                    <label for="search" class="form-label fw-semibold">Search Students</label>
                    <input type="text" class="form-control custom-input" id="search" name="search"
                        value="{{ request('search') }}" placeholder="Search by card no, name, ID or address">
                </div>
                <div class="col-lg-4">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary custom-btn flex-fill">
                            <i class="fas fa-search me-1"></i> Search
                        </button>
                        @if(request('search'))
                            <a href="{{ url()->current() }}" class="btn btn-outline-secondary custom-btn">
                                Clear
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- BULK ACTIONS --}}
        <div class="bulk-actions mb-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-id-card me-2"></i>
                        <span id="selectedCount">0</span> students selected
                    </h5>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-outline-primary me-2" id="selectAllBtn">
                        <i class="fas fa-check-double me-1"></i> Select All
                    </button>
                    <button type="button" class="btn btn-outline-secondary me-2" id="deselectAllBtn">
                        <i class="fas fa-times me-1"></i> Deselect All
                    </button>
                    <form id="bulkDownloadForm" action="{{ route('admin.student-id-cards.download-bulk') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success" id="bulkDownloadBtn" disabled>
                            <i class="fas fa-download me-1"></i>
                            Download Selected (<span id="downloadCount">0</span>)
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- STUDENTS GRID --}}
        <div class="row" id="studentsGrid">
            @if($students->count() > 0)
                @foreach($students as $student)
                    @php
                        $studentRow = $student->student;
                        $address = collect([
                            $studentRow?->address1,
                            $studentRow?->address2,
                            $studentRow?->address3,
                        ])->filter()->implode(', ');

                        $studentData = [
                            'id' => $student->id,
                            'student_id' => $student->student_id,
                            'card_no' => $student->card_no,
                            'status' => $student->status,
                            'registration_status' => $student->registration_status,
                            'created_at' => optional($student->created_at)->toDateString(),
                            'custom_id' => $studentRow?->custom_id,
                            'name' => $studentRow?->initial_name,
                            'address' => $address,
                            'img_url' => $studentRow?->img_url,
                            'mobile' => $studentRow?->guardian_mobile ?? $studentRow?->mobile,
                            'dob' => $studentRow?->dob,
                            'blood_group' => $studentRow?->blood_group,
                        ];

                        $studentKey = $studentData['custom_id'] ?? $studentData['card_no'] ?? $student->id;
                        $defaultImage = asset('storage/logo/black_logo3.png');
                        $studentImage = $studentData['img_url'] ?? $defaultImage;

                        if ($studentImage && !str_starts_with($studentImage, 'http')) {
                            $studentImage = ltrim($studentImage, '/');
                            if (str_starts_with($studentImage, 'storage/')) {
                                $studentImage = asset($studentImage);
                            } elseif (str_starts_with($studentImage, 'uploads/')) {
                                $studentImage = asset('storage/' . $studentImage);
                            } else {
                                $studentImage = asset('storage/' . $studentImage);
                            }
                        }

                        $qrData = $studentData['custom_id'] ?? $studentData['card_no'] ?? 'N/A';
                        $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=400x400&data=' . urlencode($qrData);
                    @endphp

                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4 student-card" data-id="{{ $studentKey }}"
                        data-student='@json($studentData)'>
                        <div class="premium-student-card h-100">
                            <div class="student-top d-flex justify-content-between align-items-center">
                                <div class="student-id-badge">
                                    <i class="fas fa-id-card me-1"></i> {{ $studentData['card_no'] ?? 'N/A' }}
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input student-select" value="{{ $studentKey }}"
                                        id="student_{{ $studentKey }}">
                                </div>
                            </div>

                            <div class="id-card-preview-wrap">
                                <div class="student-id-card">
                                    <!-- Smooth Background Gradients -->
                                    <div class="card-bg-gradient"></div>
                                    <div class="card-glow"></div>
                                    <div class="card-watermark">ID</div>

                                    <!-- Header - Logo Only -->
                                    <div class="card-header-id">
                                        <div class="logo-only">
                                            <img src="{{ asset('storage/logo/black_logo3.png') }}" alt="Logo" class="brand-logo">
                                        </div>
                                        <div class="card-pill">STUDENT ID</div>
                                    </div>

                                    <!-- Main Content -->
                                    <div class="card-main-id">
                                        <!-- Photo Section -->
                                        <div class="photo-section">
                                            <div class="photo-frame">
                                                <img src="{{ $studentImage }}" alt="Student Photo"
                                                    onerror="this.onerror=null;this.src='{{ $defaultImage }}'">
                                            </div>
                                        </div>

                                        <!-- Info Section - Expanded (QR section removed) -->
                                        <div class="info-section">
                                            <div class="id-number-line">
                                                <span class="id-label">ID</span>
                                                <span class="id-value">{{ $studentData['custom_id'] ?? $studentData['card_no'] ?? 'N/A' }}</span>
                                            </div>
                                            <!-- Student Name - UPPERCASE -->
                                            <div class="student-name">
                                                {{ strtoupper($studentData['name'] ?? 'Student Name') }}
                                            </div>
                                            <div class="details-grid">
                                                <div class="detail-row">
                                                    <span class="detail-label">ADDRESS</span>
                                                    <div class="detail-value">{{ Str::limit($studentData['address'] ?? 'Address not available', 65) }}</div>
                                                </div>
                                                @if(!empty($studentData['mobile']))
                                                <div class="detail-row">
                                                    <span class="detail-label">MOBILE</span>
                                                    <div class="detail-value">{{ $studentData['mobile'] }}</div>
                                                </div>
                                                @endif
                                                @if(!empty($studentData['blood_group']))
                                                <div class="detail-row">
                                                    <span class="detail-label">BLOOD GROUP</span>
                                                    <div class="detail-value">{{ $studentData['blood_group'] }}</div>
                                                </div>
                                                @endif
                                                @if(!empty($studentData['dob']))
                                                <div class="detail-row">
                                                    <span class="detail-label">DATE OF BIRTH</span>
                                                    <div class="detail-value">{{ \Carbon\Carbon::parse($studentData['dob'])->format('d M Y') }}</div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer - Clean Design -->
                                    <div class="id-footer-id">
                                        <div class="footer-line">
                                            <img src="{{ asset('storage/logo/black_logo3.png') }}" class="footer-mini-logo" alt="Logo">
                                            <div class="footer-text">MINIPALASA HIGHER EDUCATION</div>
                                        </div>
                                        <div class="footer-right">
                                            {{ now()->format('Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Area -->
                            <div class="student-action-area px-3 pb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-user me-1"></i>
                                        {{ Str::limit($studentData['name'] ?? 'N/A', 20) }}
                                    </small>
                                    @if(!empty($studentData['created_at']))
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            {{ \Carbon\Carbon::parse($studentData['created_at'])->format('Y-m-d') }}
                                        </small>
                                    @endif
                                </div>
                                <a href="{{ route('admin.student-id-cards.download-single', $student->id) }}"
                                    class="btn download-btn text-white w-100">
                                    <i class="fas fa-download me-1"></i> Download ID Card
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="alert alert-warning border-0 rounded-4 shadow-sm text-center py-5">
                        <i class="fas fa-inbox fa-3x mb-3 d-block text-muted"></i>
                        <h5>No Students Found</h5>
                        <p class="mb-0">{{ request('search') ? 'No matching students found.' : 'Please add students first to generate ID cards.' }}</p>
                    </div>
                </div>
            @endif
        </div>

        {{-- PAGINATION --}}
        @if($students->hasPages())
            <div class="row mt-4">
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center flex-wrap">
                            {{ $students->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectedStudents = new Set();
            const selectAllBtn = document.getElementById('selectAllBtn');
            const deselectAllBtn = document.getElementById('deselectAllBtn');
            const bulkDownloadBtn = document.getElementById('bulkDownloadBtn');
            const bulkDownloadForm = document.getElementById('bulkDownloadForm');

            function updateBulkActions() {
                const count = selectedStudents.size;
                document.getElementById('selectedCount').textContent = count;
                document.getElementById('downloadCount').textContent = count;
                bulkDownloadBtn.disabled = count === 0;
            }

            document.querySelectorAll('.student-select').forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const studentId = this.value;
                    const card = this.closest('.student-card');

                    if (this.checked) {
                        selectedStudents.add(studentId);
                        card.classList.add('selected');
                    } else {
                        selectedStudents.delete(studentId);
                        card.classList.remove('selected');
                    }
                    updateBulkActions();
                });
            });

            if (selectAllBtn) {
                selectAllBtn.addEventListener('click', function () {
                    document.querySelectorAll('.student-select').forEach(checkbox => {
                        checkbox.checked = true;
                        selectedStudents.add(checkbox.value);
                        checkbox.closest('.student-card').classList.add('selected');
                    });
                    updateBulkActions();
                });
            }

            if (deselectAllBtn) {
                deselectAllBtn.addEventListener('click', function () {
                    document.querySelectorAll('.student-select').forEach(checkbox => {
                        checkbox.checked = false;
                        checkbox.closest('.student-card').classList.remove('selected');
                    });
                    selectedStudents.clear();
                    updateBulkActions();
                });
            }

            if (bulkDownloadForm) {
                bulkDownloadForm.addEventListener('submit', function (e) {
                    if (selectedStudents.size === 0) {
                        e.preventDefault();
                        return;
                    }
                    bulkDownloadForm.querySelectorAll('input[name="student_ids[]"]').forEach(el => el.remove());
                    selectedStudents.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'student_ids[]';
                        input.value = id;
                        bulkDownloadForm.appendChild(input);
                    });
                });
            }

            updateBulkActions();
        });
    </script>
@endpush