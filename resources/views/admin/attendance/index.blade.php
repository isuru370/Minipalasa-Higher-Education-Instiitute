@extends('layouts.app')

@section('title', 'Attendance')
@section('page-title', 'Attendance')

@section('content')

    <div class="attendance-page">

        <!-- HERO -->
        <div class="hero-card mb-4">
            <div class="hero-content">
                <div>
                    <h4 class="mb-1 fw-bold">Attendance Management</h4>
                    <p class="mb-0 text-muted">
                        Scan a QR code or manually enter a student code to mark attendance.
                    </p>
                </div>

                <div class="hero-actions">
                    <button class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-printer me-1"></i>
                        Print
                    </button>

                    <button class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-file-earmark-excel-fill me-1"></i>
                        Export
                    </button>
                </div>
            </div>
        </div>

        <!-- ALERT -->
        <div id="attendanceAlert" class="alert alert-info d-none shadow-sm custom-alert" data-persist-alert="true"
            role="alert">

            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-info-circle-fill fs-5 mt-1" id="alertIcon"></i>

                <div class="flex-grow-1">
                    <strong id="alertTitle">Info</strong>
                    <div id="alertMessage" class="mt-1"></div>
                </div>

                <button type="button" class="btn-close" aria-label="Close"
                    onclick="document.getElementById('attendanceAlert').classList.add('d-none')">
                </button>
            </div>
        </div>

        <div class="row g-4">

            <!-- LEFT SIDE -->
            <div class="col-lg-4">

                <div class="panel-card h-100">
                    <div class="panel-header">
                        <h6 class="mb-0 fw-bold">QR Reader</h6>
                        <span class="badge bg-primary-subtle text-primary">Live</span>
                    </div>

                    <div class="panel-body">
                        <ul class="nav nav-pills custom-pills mb-3" role="tablist">
                            <li class="nav-item me-2">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#scanTab"
                                    type="button">
                                    Scan QR
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#manualTab" type="button">
                                    Manual Entry
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <!-- SCAN -->
                            <div class="tab-pane fade show active" id="scanTab">
                                <div id="qr-reader" class="qr-reader-box"></div>

                                <div class="d-grid gap-2 mt-3">
                                    <button type="button" class="btn btn-primary custom-btn" id="startScannerBtn">
                                        <i class="bi bi-camera-fill me-1"></i>
                                        Start Scanner
                                    </button>

                                    <button type="button" class="btn btn-outline-secondary custom-btn d-none"
                                        id="stopScannerBtn">
                                        <i class="bi bi-stop-circle me-1"></i>
                                        Stop Scanner
                                    </button>
                                </div>

                                <small class="text-muted d-block mt-3">
                                    Camera scanning requires HTTPS or localhost.
                                </small>
                            </div>

                            <!-- MANUAL -->
                            <div class="tab-pane fade" id="manualTab">
                                <form id="manualQrForm" autocomplete="off">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="manualQrCode" class="form-label fw-semibold">
                                            Student QR / Code
                                        </label>

                                        <div class="input-group custom-input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-upc-scan"></i>
                                            </span>

                                            <input type="text" class="form-control custom-input" id="manualQrCode"
                                                placeholder="Enter QR code" maxlength="150">
                                        </div>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-success custom-btn" id="manualReadBtn">
                                            <i class="bi bi-person-check-fill me-1"></i>
                                            Read Student
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-8">

                <!-- EMPTY STATE -->
                <div id="emptyStateCard" class="panel-card">
                    <div class="panel-body text-center py-5">
                        <div class="empty-icon">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <h5 class="fw-bold mb-2">No Student Selected</h5>
                        <p class="text-muted mb-0">
                            Scan a QR code or enter a student code manually.
                        </p>
                    </div>
                </div>

                <!-- STUDENT DETAILS -->
                <div id="studentDetailsCard" class="panel-card d-none mb-4">
                    <div class="panel-header">
                        <h6 class="mb-0 fw-bold">Student Details</h6>
                        <span class="badge bg-secondary" id="qrTypeBadge">-</span>
                    </div>

                    <div class="panel-body">
                        <div class="row align-items-center g-4">
                            <div class="col-md-3 text-center">
                                <img id="studentImage" src="{{ asset('images/default-student.png') }}" class="student-image"
                                    alt="Student Image">
                            </div>

                            <div class="col-md-9">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="detail-box">
                                            <small class="text-muted">Student ID</small>
                                            <div class="fw-bold" id="studentId">-</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="detail-box">
                                            <small class="text-muted">Name</small>
                                            <div class="fw-bold" id="studentName">-</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="detail-box">
                                            <small class="text-muted">Mobile</small>
                                            <div class="fw-bold" id="studentMobile">-</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="detail-box">
                                            <small class="text-muted">Guardian Mobile</small>
                                            <div class="fw-bold" id="guardianMobile">-</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ATTENDANCE DETAILS -->
                <div id="attendanceDetailsCard" class="panel-card d-none">
                    <div class="panel-header">
                        <h6 class="mb-0 fw-bold">Attendance Details</h6>
                        <span class="badge bg-success-subtle text-success">Ready</span>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Class</th>
                                        <th>Grade</th>
                                        <th>Subject</th>
                                        <th>Teacher</th>
                                        <th>Category</th>
                                        <th>Final Fee</th>
                                        <th>Last Payment</th>
                                        <th>Attendance</th>
                                        <th width="230" class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody id="attendanceTableBody">
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            No details found.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ERROR DETAILS -->
                <div id="errorDetailsCard" class="panel-card mt-4 d-none">
                    <div class="panel-header bg-danger text-white rounded-top-4">
                        <h6 class="mb-0 fw-bold">Error Details</h6>
                    </div>
                    <div class="panel-body">
                        <div id="errorDetails"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ADD CLASS MODAL -->
    <div class="modal fade" id="addClassModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form id="addClassForm" autocomplete="off">
                    @csrf

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Add Student To Class</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body pt-0">

                        <div class="alert alert-light border">
                            <div><strong>Student:</strong> <span id="modalStudentName">-</span></div>
                            <div><strong>Class:</strong> <span id="modalClassName">-</span></div>
                            <div><strong>Category:</strong> <span id="modalCategoryName">-</span></div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Free Card</label>
                                <select id="modalIsFreeCard" class="form-select custom-input">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Custom Fee</label>
                                <input type="number" step="0.01" min="0" id="modalCustomFee"
                                    class="form-control custom-input">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold">Discount %</label>
                                <input type="number" step="0.01" min="0" max="100" id="modalDiscountPercentage"
                                    class="form-control custom-input">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Custom Fee Reason</label>
                                <select id="modalCustomFeeReason" class="form-select custom-input">
                                    <option value="">Select Reason</option>
                                    <option value="Student enrolled in multiple categories">Student enrolled in multiple
                                        categories</option>
                                    <option value="Special Discount">Special Discount</option>
                                    <option value="Scholarship">Scholarship</option>
                                    <option value="Sibling Discount">Sibling Discount</option>
                                    <option value="Staff Child">Staff Child</option>
                                    <option value="Promotional">Promotional</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Discount Reason</label>
                                <select id="modalDiscountReason" class="form-select custom-input">
                                    <option value="">Select Reason</option>
                                    <option value="Half Card">Half Card</option>
                                    <option value="Special Discount">Special Discount</option>
                                    <option value="Scholarship">Scholarship</option>
                                    <option value="Sibling Discount">Sibling Discount</option>
                                    <option value="Staff Child">Staff Child</option>
                                    <option value="Promotional">Promotional</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Enrolled At</label>
                                <input type="date" id="modalEnrolledAt" class="form-control custom-input"
                                    value="{{ now()->toDateString() }}">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary custom-btn" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary custom-btn" id="saveClassBtn">
                            Save Class
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .attendance-page {
            animation: fadeIn .4s ease;
        }

        .hero-card,
        .panel-card {
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .05);
            border: 1px solid #eef2f7;
            overflow: hidden;
        }

        .hero-card {
            padding: 1.35rem 1.5rem;
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

        .panel-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid #eef2f7;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            background: #fff;
        }

        .panel-body {
            padding: 1.25rem;
        }

        .custom-btn {
            border-radius: 14px;
            padding: .7rem 1.15rem;
            font-weight: 600;
            border: none;
            transition: .2s ease;
        }

        .custom-btn:hover {
            transform: translateY(-2px);
        }

        .custom-pills .nav-link {
            border-radius: 12px;
            font-weight: 600;
            color: #475569;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .custom-pills .nav-link.active {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            color: #fff;
            border-color: transparent;
        }

        .qr-reader-box {
            width: 100%;
            min-height: 320px;
            border-radius: 18px;
            overflow: hidden;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
        }

        .custom-input-group {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            background: #fff;
        }

        .custom-input-group .input-group-text {
            background: #f8fafc;
            border: none;
            color: #64748b;
        }

        .custom-input,
        .custom-input:focus {
            border: none;
            box-shadow: none;
            min-height: 48px;
        }

        .student-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 18px;
            border: 3px solid #e2e8f0;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .06);
            background: #f8fafc;
        }

        .detail-box {
            background: #f8fafc;
            border: 1px solid #eef2f7;
            border-radius: 18px;
            padding: .9rem 1rem;
        }

        .custom-table thead th {
            border: none;
            background: #f8fafc;
            color: #475569;
            font-size: .82rem;
            text-transform: uppercase;
            padding: 1rem;
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

        .empty-icon {
            width: 72px;
            height: 72px;
            border-radius: 22px;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #2563eb;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .custom-alert {
            border-radius: 18px;
        }

        @media (max-width: 768px) {
            .hero-content {
                flex-direction: column;
                align-items: stretch;
            }

            .hero-actions {
                width: 100%;
            }

            .hero-actions .btn {
                flex: 1;
            }

            .student-image {
                width: 130px;
                height: 130px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const readApiUrl = @json(route('api.attendance.read'));
            const storeAttendanceApiUrl = @json(route('api.attendance.store'));
            const storeEnrollmentApiUrl = @json(route('api.student-class-enrollments.store'));

            const defaultStudentImage = @json(asset('images/default-student.png'));

            const classScheduleId = @json(request('class_schedule_id'));
            const studentClassId = @json(request('student_class_id'));
            const classCategoryFeeId = @json(request('class_category_fee_id'));

            const alertBox = document.getElementById('attendanceAlert');
            const alertIcon = document.getElementById('alertIcon');
            const alertTitle = document.getElementById('alertTitle');
            const alertMessage = document.getElementById('alertMessage');
            const errorDetailsCard = document.getElementById('errorDetailsCard');
            const errorDetails = document.getElementById('errorDetails');

            const emptyStateCard = document.getElementById('emptyStateCard');
            const studentDetailsCard = document.getElementById('studentDetailsCard');
            const attendanceDetailsCard = document.getElementById('attendanceDetailsCard');

            const studentImage = document.getElementById('studentImage');
            const studentId = document.getElementById('studentId');
            const studentName = document.getElementById('studentName');
            const studentMobile = document.getElementById('studentMobile');
            const guardianMobile = document.getElementById('guardianMobile');
            const qrTypeBadge = document.getElementById('qrTypeBadge');
            const attendanceTableBody = document.getElementById('attendanceTableBody');

            const manualQrForm = document.getElementById('manualQrForm');
            const manualQrCode = document.getElementById('manualQrCode');
            const manualReadBtn = document.getElementById('manualReadBtn');

            const startScannerBtn = document.getElementById('startScannerBtn');
            const stopScannerBtn = document.getElementById('stopScannerBtn');

            const addClassModalEl = document.getElementById('addClassModal');
            const addClassModal = addClassModalEl ? new bootstrap.Modal(addClassModalEl) : null;
            const addClassForm = document.getElementById('addClassForm');
            const saveClassBtn = document.getElementById('saveClassBtn');

            const modalStudentName = document.getElementById('modalStudentName');
            const modalClassName = document.getElementById('modalClassName');
            const modalCategoryName = document.getElementById('modalCategoryName');

            const modalIsFreeCard = document.getElementById('modalIsFreeCard');
            const modalCustomFee = document.getElementById('modalCustomFee');
            const modalCustomFeeReason = document.getElementById('modalCustomFeeReason');
            const modalDiscountPercentage = document.getElementById('modalDiscountPercentage');
            const modalDiscountReason = document.getElementById('modalDiscountReason');
            const modalEnrolledAt = document.getElementById('modalEnrolledAt');

            let html5QrCode = null;
            let scannerRunning = false;
            let processing = false;
            let lastScannedCode = null;
            let lastScanTime = 0;
            let currentQrCode = null;
            let currentStudent = null;
            let currentEnrollment = null;
            let currentMarkMethod = 'qr_web';

            const SCAN_COOLDOWN_MS = 1200;

            function showAlert(type, message) {
                const safeType = ['success', 'danger', 'warning', 'info'].includes(type) ? type : 'info';

                alertBox.className = `alert alert-${safeType} shadow-sm custom-alert`;
                alertBox.setAttribute('data-persist-alert', 'true');
                alertBox.classList.remove('d-none');
                alertBox.style.display = 'block';

                if (alertIcon) {
                    alertIcon.className =
                        safeType === 'success' ? 'bi bi-check-circle-fill fs-5 mt-1' :
                            safeType === 'danger' ? 'bi bi-exclamation-triangle-fill fs-5 mt-1' :
                                safeType === 'warning' ? 'bi bi-exclamation-circle-fill fs-5 mt-1' :
                                    'bi bi-info-circle-fill fs-5 mt-1';
                }

                alertTitle.textContent =
                    safeType === 'success' ? 'Success' :
                        safeType === 'danger' ? 'Error' :
                            safeType === 'warning' ? 'Warning' : 'Info';

                alertMessage.textContent = message || '';
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            function hideAlert() {
                alertBox.classList.add('d-none');
                alertMessage.textContent = '';
            }

            function setReadButtonLoading(isLoading) {
                if (!manualReadBtn) return;

                manualReadBtn.disabled = isLoading;
                manualReadBtn.innerHTML = isLoading
                    ? '<span class="spinner-border spinner-border-sm me-1"></span>Processing...'
                    : '<i class="bi bi-person-check-fill me-1"></i>Read Student';
            }

            async function postJson(url, payload) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                });

                let result = {};
                try {
                    result = await response.json();
                } catch (error) {
                    result = { message: 'Invalid server response.' };
                }

                return { ok: response.ok, status: response.status, result };
            }

            async function readStudent(qrCode, method = 'qr_web') {
                const code = String(qrCode || '').trim();

                currentMarkMethod = method;

                hideAlert();

                if (!code) {
                    showAlert('warning', 'Please enter or scan QR code.');
                    return;
                }

                if (!classScheduleId || !studentClassId || !classCategoryFeeId) {
                    showAlert('danger', 'Class schedule, class ID or category fee ID missing.');
                    return;
                }

                if (processing) return;

                try {
                    processing = true;
                    setReadButtonLoading(true);

                    const response = await postJson(readApiUrl, {
                        qr_code: code,
                        student_class_id: studentClassId,
                        class_category_fee_id: classCategoryFeeId,
                    });

                    const result = response.result;

                    if (!response.ok || result.status !== 'success') {
                        resetView();
                        showAlert('danger', result.message || 'Student read failed.');
                        return;
                    }

                    currentQrCode = code;
                    currentStudent = result.data.student;
                    currentEnrollment = result.data.enrollment;

                    renderStudent(currentStudent);
                    renderAttendanceDetails(result.data);

                    showAlert('success', result.message || 'Student attendance details loaded successfully.');
                    manualQrCode.value = code;

                } catch (error) {
                    console.error(error);
                    resetView();
                    showAlert('danger', 'Something went wrong while reading student.');
                } finally {
                    processing = false;
                    setReadButtonLoading(false);
                }
            }

            function renderStudent(student) {
                emptyStateCard.classList.add('d-none');
                studentDetailsCard.classList.remove('d-none');
                attendanceDetailsCard.classList.remove('d-none');

                studentImage.src = student.img_url || defaultStudentImage;
                studentImage.onerror = function () {
                    this.src = defaultStudentImage;
                    this.onerror = null;
                };

                studentId.textContent = student.custom_id || student.id || '-';
                studentName.textContent = student.initial_name || '-';
                studentMobile.textContent = student.mobile || '-';
                guardianMobile.textContent = student.guardian_mobile || '-';

                qrTypeBadge.textContent = student.qr_type === 'temporary' ? 'Temporary QR' : 'Permanent QR';
                qrTypeBadge.className = student.qr_type === 'temporary'
                    ? 'badge bg-warning text-dark'
                    : 'badge bg-success';
            }

            function renderAttendanceDetails(data) {
                const enrollment = data.enrollment || {};
                const attendance = data.attendance || {};
                const lastPayment = data.last_payment || null;
                const isNewStudent = enrollment.status === 'new_student';

                attendanceTableBody.innerHTML = `
                                    <tr>
                                        <td>
                                            ${isNewStudent
                        ? '<span class="badge bg-warning text-dark">New Student</span>'
                        : '<span class="badge bg-success">Enrolled</span>'
                    }
                                        </td>

                                        <td>
                                            <div class="fw-bold">${escapeHtml(enrollment.class_name)}</div>
                                            <small class="text-muted">Class ID: ${escapeHtml(enrollment.student_class_id)}</small>
                                        </td>

                                        <td>${escapeHtml(enrollment.grade)}</td>
                                        <td>${escapeHtml(enrollment.subject)}</td>
                                        <td>${escapeHtml(enrollment.teacher)}</td>

                                        <td>
                                            <div>${escapeHtml(enrollment.category_name)}</div>
                                            <small class="text-muted">Fee ID: ${escapeHtml(enrollment.class_category_fee_id)}</small>
                                        </td>

                                        <td>
                                            <div class="fw-bold">${formatMoney(enrollment.final_fee)}</div>
                                            <small class="text-muted">Default: ${formatMoney(enrollment.default_fee)}</small>
                                        </td>

                                        <td>${renderLastPayment(lastPayment)}</td>

                                        <td>
                                            <div class="fw-bold">${attendance.attended_classes ?? 0} / ${attendance.total_classes ?? 0}</div>
                                            <small class="text-muted">
                                                ${attendance.attendance_percentage ?? 0}%
                                                ${attendance.month ? '(' + escapeHtml(attendance.month) + ')' : ''}
                                            </small>
                                        </td>

                                        <td>
                                            <div class="d-flex gap-1 flex-wrap justify-content-end">
                                                ${isNewStudent
                        ? `
                                                            <button type="button"
                                                                    class="btn btn-sm btn-primary custom-btn"
                                                                    id="addClassBtn">
                                                                Add Class
                                                            </button>
                                                        `
                        : ''
                    }

                                                <button type="button"
                                                        class="btn btn-sm btn-success custom-btn"
                                                        id="markAttendanceBtn">
                                                    Mark Attendance
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                `;
            }

            function renderLastPayment(payment) {
                if (!payment) {
                    return '<span class="badge bg-danger">No Payment Yet</span>';
                }

                return `
                                    <div class="fw-bold">${formatMoney(payment.amount)}</div>
                                    <small class="text-muted">Month: ${escapeHtml(payment.payment_month)}</small><br>
                                    <small class="text-info">Paid: ${escapeHtml(payment.paid_at)}</small>
                                `;
            }

            async function markAttendance() {
                if (!currentQrCode) {
                    showAlert('warning', 'Please read a student first.');
                    return;
                }

                if (!classScheduleId || !studentClassId || !classCategoryFeeId) {
                    showAlert('danger', 'Required class details missing.');
                    return;
                }

                try {
                    const button = document.getElementById('markAttendanceBtn');

                    if (button) {
                        button.disabled = true;
                        button.textContent = 'Marking...';
                    }

                    const response = await postJson(storeAttendanceApiUrl, {
                        qr_code: currentQrCode,
                        class_schedule_id: classScheduleId,
                        student_class_id: studentClassId,
                        class_category_fee_id: classCategoryFeeId,
                        mark_method: currentMarkMethod,
                        note: null,
                    });

                    const result = response.result;

                    if (!response.ok || result.status !== 'success') {
                        showAlert('danger', result.message || 'Attendance mark failed.');
                        return;
                    }

                    showAlert('success', result.message || 'Attendance marked successfully.');

                    await readStudent(currentQrCode);

                } catch (error) {
                    console.error(error);
                    showAlert('danger', 'Something went wrong while marking attendance.');
                }
            }

            function openAddClassModal() {
                if (!currentStudent || !currentEnrollment) {
                    showAlert('warning', 'Please read a student first.');
                    return;
                }

                modalStudentName.textContent = currentStudent.initial_name || currentStudent.custom_id || '-';
                modalClassName.textContent = currentEnrollment.class_name || '-';
                modalCategoryName.textContent = currentEnrollment.category_name || '-';

                modalIsFreeCard.value = '0';
                modalCustomFee.value = '';
                modalCustomFeeReason.value = '';
                modalDiscountPercentage.value = '';
                modalDiscountReason.value = '';
                modalEnrolledAt.value = new Date().toISOString().slice(0, 10);

                addClassModal?.show();
            }

            async function saveClassEnrollment() {
                if (!currentStudent) {
                    showAlert('warning', 'Please read a student first.');
                    return;
                }

                try {
                    saveClassBtn.disabled = true;
                    saveClassBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

                    const payload = {
                        student_id: currentStudent.id,
                        student_class_id: studentClassId,
                        class_category_fee_id: classCategoryFeeId,
                        is_free_card: modalIsFreeCard.value === '1' ? 1 : 0,
                        custom_fee: modalCustomFee.value || null,
                        custom_fee_reason: modalCustomFeeReason.value || null,
                        discount_percentage: modalDiscountPercentage.value || null,
                        discount_reason: modalDiscountReason.value || null,
                        enrolled_at: modalEnrolledAt.value || null,
                        note: null,
                    };

                    const response = await postJson(storeEnrollmentApiUrl, payload);
                    const result = response.result;

                    if (!response.ok || result.status !== 'success') {
                        showAlert('danger', result.message || 'Student class enrollment failed.');
                        return;
                    }

                    addClassModal?.hide();
                    showAlert('success', 'Student enrolled successfully.');

                    if (currentQrCode) {
                        await readStudent(currentQrCode);
                    }

                } catch (error) {
                    console.error(error);
                    showAlert('danger', 'Something went wrong while saving class.');
                } finally {
                    saveClassBtn.disabled = false;
                    saveClassBtn.textContent = 'Save Class';
                }
            }

            function resetView() {
                currentQrCode = null;
                currentStudent = null;
                currentEnrollment = null;

                emptyStateCard.classList.remove('d-none');
                studentDetailsCard.classList.add('d-none');
                attendanceDetailsCard.classList.add('d-none');

                attendanceTableBody.innerHTML = `
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">
                                            No details found.
                                        </td>
                                    </tr>
                                `;
            }

            function formatMoney(value) {
                if (value === null || value === undefined || value === '') return '-';

                const amount = Number(value);
                if (Number.isNaN(amount)) return '-';

                return 'Rs. ' + amount.toLocaleString('en-LK', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function escapeHtml(value) {
                if (value === null || value === undefined || value === '') return '-';

                return String(value)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            async function startScanner() {
                if (scannerRunning) return;

                if (typeof Html5Qrcode === 'undefined') {
                    showAlert('danger', 'QR scanner library failed to load.');
                    return;
                }

                try {
                    html5QrCode = new Html5Qrcode('qr-reader');

                    startScannerBtn.disabled = true;
                    startScannerBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Starting Scanner...';

                    await html5QrCode.start(
                        { facingMode: 'environment' },
                        {
                            fps: 10,
                            qrbox: 250
                        },
                        function (decodedText) {
                            const code = String(decodedText || '').trim();
                            const now = Date.now();

                            if (!code) return;

                            if (code === lastScannedCode && now - lastScanTime < SCAN_COOLDOWN_MS) {
                                return;
                            }

                            lastScannedCode = code;
                            lastScanTime = now;

                            readStudent(code, 'qr_web');
                        }
                    );

                    scannerRunning = true;
                    startScannerBtn.innerHTML = '<i class="bi bi-camera-video-fill me-1"></i>Scanner Running';
                    startScannerBtn.disabled = true;
                    stopScannerBtn.classList.remove('d-none');

                } catch (error) {
                    console.error(error);
                    showAlert('danger', 'Could not start scanner.');
                    startScannerBtn.disabled = false;
                    startScannerBtn.innerHTML = '<i class="bi bi-camera-fill me-1"></i>Start Scanner';
                }
            }

            async function stopScanner() {
                if (html5QrCode && scannerRunning) {
                    await html5QrCode.stop();
                    await html5QrCode.clear();
                }

                scannerRunning = false;
                html5QrCode = null;
                lastScannedCode = null;
                lastScanTime = 0;

                startScannerBtn.disabled = false;
                startScannerBtn.innerHTML = '<i class="bi bi-camera-fill me-1"></i>Start Scanner';
                stopScannerBtn.classList.add('d-none');
            }

            manualQrForm.addEventListener('submit', function (event) {
                event.preventDefault();
                readStudent(manualQrCode.value, 'manual_web');
            });

            addClassForm.addEventListener('submit', function (event) {
                event.preventDefault();
                saveClassEnrollment();
            });

            startScannerBtn.addEventListener('click', startScanner);
            stopScannerBtn.addEventListener('click', stopScanner);

            attendanceTableBody.addEventListener('click', function (event) {
                if (event.target.closest('#addClassBtn')) {
                    openAddClassModal();
                }

                if (event.target.closest('#markAttendanceBtn')) {
                    markAttendance();
                }
            });

            window.addEventListener('beforeunload', function () {
                if (html5QrCode && scannerRunning) {
                    html5QrCode.stop().catch(function () { });
                }
            });
        });
    </script>
@endpush