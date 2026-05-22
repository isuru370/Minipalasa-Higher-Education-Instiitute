@extends('layouts.app')

@section('title', 'Student Payments')
@section('page-title', 'Student Payments')

@section('content')

    <div class="payments-page">

        <!-- HERO -->
        <div class="hero-card mb-4">
            <div class="hero-content">
                <div>
                    <h4 class="mb-1 fw-bold">Payment Management</h4>
                    <p class="mb-0 text-muted">
                        Scan a QR code or enter a student code manually to continue the payment flow.
                    </p>
                </div>

                <div class="hero-actions">
                    <button class="btn btn-light border custom-btn" disabled>
                        <i class="bi bi-printer me-1"></i>
                        Print
                    </button>

                    <a href="{{ route('admin.payments.today-receipt') }}" class="btn btn-light border custom-btn">
                        <i class="bi bi-receipt me-1"></i>
                        Receipt
                    </a>
                </div>
            </div>
        </div>

        <!-- ALERT -->
        <div id="paymentAlert" class="alert alert-info d-none shadow-sm custom-alert" data-persist-alert="true"
            role="alert">

            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-info-circle-fill fs-5 mt-1" id="alertIcon"></i>

                <div class="flex-grow-1">
                    <strong id="alertTitle">Information</strong>
                    <div id="alertMessage" class="mt-1"></div>
                </div>

                <button type="button" class="btn-close" aria-label="Close"
                    onclick="document.getElementById('paymentAlert').classList.add('d-none')">
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
                                <button class="nav-link active" id="scanTabBtn" data-bs-toggle="tab"
                                    data-bs-target="#scanTab" type="button" role="tab">
                                    Scan QR
                                </button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" id="manualTabBtn" data-bs-toggle="tab" data-bs-target="#manualTab"
                                    type="button" role="tab">
                                    Manual Entry
                                </button>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <!-- QR SCAN -->
                            <div class="tab-pane fade show active" id="scanTab" role="tabpanel">
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

                            <!-- MANUAL ENTRY -->
                            <div class="tab-pane fade" id="manualTab" role="tabpanel">
                                <form id="manualQrForm" autocomplete="off" novalidate>
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
                                                name="qr_code" placeholder="Enter QR code" maxlength="150"
                                                autocomplete="off">
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
                                            <small class="text-muted">Mobile Number</small>
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

                <!-- CLASS DETAILS -->
                <div id="classDetailsCard" class="panel-card d-none mb-4">
                    <div class="panel-header">
                        <h6 class="mb-0 fw-bold">Class Details</h6>
                        <span class="badge bg-primary-subtle text-primary">Ready for Payment</span>
                    </div>

                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table custom-table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Category</th>
                                        <th>Teacher</th>
                                        <th>Grade</th>
                                        <th>Subject</th>
                                        <th>Final Fee</th>
                                        <th>Attendance</th>
                                        <th>Last Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="classTableBody">
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            No class details found.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- EMPTY STATE -->
                <div id="emptyStateCard" class="panel-card">
                    <div class="panel-body text-center py-5">
                        <div class="empty-icon">
                            <i class="bi bi-qr-code-scan"></i>
                        </div>
                        <h5 class="fw-bold mb-2">No Student Selected</h5>
                        <p class="text-muted mb-0">
                            Scan a QR code or enter a student code manually to view payment details.
                        </p>
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

    <!-- PAYMENT MODAL -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <form id="paymentForm" autocomplete="off" novalidate>
                    @csrf

                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold">Make Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body pt-0">
                        <input type="hidden" id="payStudentId">
                        <input type="hidden" id="payEnrollmentId">

                        <div class="detail-box mb-4">
                            <small class="text-muted">Class</small>
                            <div class="fw-bold" id="payClassName">-</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="payMonth" class="form-label fw-semibold">Payment Month</label>
                                <input type="month" class="form-control custom-input" id="payMonth" required>
                            </div>

                            <div class="col-md-6">
                                <label for="payAmount" class="form-label fw-semibold">Amount</label>
                                <input type="number" class="form-control custom-input" id="payAmount" min="0" step="0.01"
                                    required>
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="payDiscount" class="form-label fw-semibold">Discount Amount</label>
                            <input type="number" class="form-control custom-input" id="payDiscount" min="0" step="0.01"
                                value="0" disabled>
                        </div>

                        <div class="alert alert-light border mt-4 mb-0">
                            <div class="small text-muted">Payment Method</div>
                            <div class="fw-bold">Cash</div>
                        </div>
                    </div>

                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary custom-btn" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-success custom-btn" id="savePaymentBtn">
                            Save Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .payments-page {
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

        .custom-input {
            border: none;
            min-height: 48px;
            border-radius: 14px !important;
            box-shadow: none;
        }

        .custom-input:focus {
            box-shadow: none;
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
            'use strict';

            const readApiUrl = @json(route('api.payments.read'));
            const storePaymentApiUrl = @json(route('api.student-payments.store'));
            const defaultStudentImage = @json(asset('images/default-student.png'));
            const SCAN_COOLDOWN_MS = 1200;

            const startScannerBtn = document.getElementById('startScannerBtn');
            const stopScannerBtn = document.getElementById('stopScannerBtn');
            const manualReadBtn = document.getElementById('manualReadBtn');
            const manualQrForm = document.getElementById('manualQrForm');
            const manualQrCode = document.getElementById('manualQrCode');
            const manualTabBtn = document.getElementById('manualTabBtn');

            const alertBox = document.getElementById('paymentAlert');
            const alertIcon = document.getElementById('alertIcon');
            const alertTitle = document.getElementById('alertTitle');
            const alertMessage = document.getElementById('alertMessage');
            const emptyStateCard = document.getElementById('emptyStateCard');
            const studentDetailsCard = document.getElementById('studentDetailsCard');
            const classDetailsCard = document.getElementById('classDetailsCard');
            const errorDetailsCard = document.getElementById('errorDetailsCard');
            const errorDetails = document.getElementById('errorDetails');

            const studentImage = document.getElementById('studentImage');
            const studentId = document.getElementById('studentId');
            const studentName = document.getElementById('studentName');
            const studentMobile = document.getElementById('studentMobile');
            const guardianMobile = document.getElementById('guardianMobile');
            const qrTypeBadge = document.getElementById('qrTypeBadge');
            const classTableBody = document.getElementById('classTableBody');

            const paymentModalEl = document.getElementById('paymentModal');
            const paymentModal = paymentModalEl ? new bootstrap.Modal(paymentModalEl) : null;
            const paymentForm = document.getElementById('paymentForm');
            const savePaymentBtn = document.getElementById('savePaymentBtn');
            const payStudentId = document.getElementById('payStudentId');
            const payEnrollmentId = document.getElementById('payEnrollmentId');
            const payClassName = document.getElementById('payClassName');
            const payMonth = document.getElementById('payMonth');
            const payAmount = document.getElementById('payAmount');
            const payDiscount = document.getElementById('payDiscount');

            let html5QrCode = null;
            let scannerRunning = false;
            let processingRequest = false;
            let lastScannedCode = null;
            let lastScanTime = 0;
            let successAlertTimer = null;
            let currentStudent = null;
            let currentQrCode = null;
            let currentClasses = [];

            function showAlert(type, message, errors = null) {
                if (!alertBox) {
                    alert(message || 'Something went wrong.');
                    return;
                }

                if (successAlertTimer) {
                    clearTimeout(successAlertTimer);
                    successAlertTimer = null;
                }

                hideErrorDetails();

                const safeType = ['success', 'danger', 'warning', 'info'].includes(type) ? type : 'info';

                alertBox.className = `alert alert-${safeType} shadow-sm custom-alert`;
                alertBox.setAttribute('data-persist-alert', 'true');
                alertBox.classList.remove('d-none');
                alertBox.style.display = 'block';

                if (alertIcon) {
                    alertIcon.className = getAlertIconClass(safeType);
                }

                if (alertTitle) {
                    alertTitle.textContent = getAlertTitle(safeType);
                }

                if (alertMessage) {
                    alertMessage.textContent = message || 'Something went wrong.';
                }

                if (errors) {
                    showErrorDetails(errors);
                }

                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });

                if (safeType === 'success') {
                    successAlertTimer = setTimeout(hideAlert, 5000);
                }
            }

            function getAlertTitle(type) {
                if (type === 'success') return 'Success';
                if (type === 'danger') return 'Error';
                if (type === 'warning') return 'Warning';
                return 'Information';
            }

            function getAlertIconClass(type) {
                if (type === 'success') return 'bi bi-check-circle-fill fs-5';
                if (type === 'danger') return 'bi bi-exclamation-triangle-fill fs-5';
                if (type === 'warning') return 'bi bi-exclamation-circle-fill fs-5';
                return 'bi bi-info-circle-fill fs-5';
            }

            function hideAlert() {
                if (!alertBox) return;

                alertBox.classList.add('d-none');
                alertBox.style.display = 'none';

                if (alertMessage) {
                    alertMessage.textContent = '';
                }

                hideErrorDetails();
            }

            function showErrorDetails(errors) {
                if (!errorDetailsCard || !errorDetails) return;

                const items = [];

                if (typeof errors === 'string') {
                    items.push(errors);
                } else if (Array.isArray(errors)) {
                    errors.forEach(error => items.push(String(error)));
                } else if (typeof errors === 'object') {
                    Object.entries(errors).forEach(([field, messages]) => {
                        if (Array.isArray(messages)) {
                            messages.forEach(message => items.push(`${field}: ${message}`));
                        } else {
                            items.push(`${field}: ${messages}`);
                        }
                    });
                }

                if (!items.length) return;

                const list = document.createElement('ul');
                list.className = 'mb-0';

                items.forEach(item => {
                    const li = document.createElement('li');
                    li.textContent = item;
                    list.appendChild(li);
                });

                errorDetails.innerHTML = '';
                errorDetails.appendChild(list);
                errorDetailsCard.classList.remove('d-none');
            }

            function hideErrorDetails() {
                if (errorDetailsCard) errorDetailsCard.classList.add('d-none');
                if (errorDetails) errorDetails.innerHTML = '';
            }

            function setLoading(isLoading) {
                processingRequest = isLoading;

                if (manualReadBtn) {
                    manualReadBtn.disabled = isLoading;
                    manualReadBtn.innerHTML = isLoading
                        ? '<span class="spinner-border spinner-border-sm me-1"></span>Processing...'
                        : '<i class="bi bi-person-check-fill me-1"></i>Read Student';
                }

                if (startScannerBtn) {
                    startScannerBtn.disabled = scannerRunning || isLoading;
                    startScannerBtn.innerHTML = scannerRunning
                        ? '<i class="bi bi-camera-video-fill me-1"></i>Scanner Running'
                        : '<i class="bi bi-camera-fill me-1"></i>Start Scanner';
                }
            }

            async function readStudent(qrCode, source = 'manual', showSuccessMessage = true) {
                const cleanedQrCode = String(qrCode || '').trim();

                hideAlert();

                if (!cleanedQrCode) {
                    showAlert('warning', 'Please enter or scan a valid QR code.');
                    return;
                }

                if (processingRequest) return;

                try {
                    setLoading(true);

                    const response = await postJson(readApiUrl, {
                        qr_code: cleanedQrCode
                    });

                    const result = response.result;

                    if (!response.ok || result.status !== 'success') {
                        resetView();
                        showAlert('danger', getErrorMessage(response.status, result), result.errors || null);
                        return;
                    }

                    if (!result.data || !result.data.student) {
                        throw new Error('Student data not found in server response.');
                    }

                    currentQrCode = cleanedQrCode;
                    currentStudent = result.data.student;
                    currentClasses = result.data.classes || [];

                    renderStudent(currentStudent);
                    renderClasses(currentClasses);

                    if (showSuccessMessage) {
                        showAlert('success', result.message || 'Student payment details loaded successfully.');
                    }

                    if (manualQrCode) {
                        manualQrCode.value = cleanedQrCode;
                    }
                } catch (error) {
                    console.error('Read student error:', error);
                    resetView();
                    showAlert('danger', error.message || 'Something went wrong while reading QR code.');
                } finally {
                    setLoading(false);

                    if (source === 'scanner') {
                        setTimeout(() => {
                            lastScannedCode = null;
                        }, SCAN_COOLDOWN_MS);
                    } else {
                        lastScannedCode = null;
                    }
                }
            }

            async function postJson(url, payload) {
                const csrfToken = document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute('content');

                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken || '',
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify(payload)
                });

                const result = await parseServerResponse(response);

                return {
                    ok: response.ok,
                    status: response.status,
                    result
                };
            }

            async function parseServerResponse(response) {
                const contentType = response.headers.get('content-type') || '';
                const rawText = await response.text();

                if (!rawText || !rawText.trim()) {
                    throw new Error('Empty response from server.');
                }

                if (!contentType.includes('application/json')) {
                    if (response.status === 419) {
                        throw new Error('Session expired or CSRF token mismatch. Please refresh the page and try again.');
                    }

                    if (response.redirected || rawText.includes('<html') || rawText.includes('<!DOCTYPE')) {
                        throw new Error('Server returned HTML instead of JSON. Check API route, login session, or middleware.');
                    }

                    throw new Error('Invalid response format from server.');
                }

                try {
                    return JSON.parse(rawText);
                } catch (error) {
                    throw new Error('Invalid JSON response from server.');
                }
            }

            function getErrorMessage(status, result) {
                if (result?.message) return result.message;
                if (result?.errors?.qr_code?.[0]) return result.errors.qr_code[0];
                if (result?.errors?.payment_month?.[0]) return result.errors.payment_month[0];
                if (result?.errors?.amount?.[0]) return result.errors.amount[0];

                if (status === 401) return 'Please login again and try again.';
                if (status === 403) return 'This action is not allowed.';
                if (status === 404) return 'Record not found.';
                if (status === 419) return 'Session expired. Please refresh the page and try again.';
                if (status === 422) return 'Validation failed. Please check the entered data.';
                if (status === 500) return 'Server error occurred. Please try again later.';

                return `Request failed with status ${status}.`;
            }

            function renderStudent(student) {
                emptyStateCard.classList.add('d-none');
                studentDetailsCard.classList.remove('d-none');
                classDetailsCard.classList.remove('d-none');

                studentImage.src = student.img_url || defaultStudentImage;
                studentImage.onerror = function () {
                    this.src = defaultStudentImage;
                    this.onerror = null;
                };

                studentId.textContent = student.custom_id || student.id || '-';
                studentName.textContent = student.initial_name || student.name || '-';
                studentMobile.textContent = student.mobile || '-';
                guardianMobile.textContent = student.guardian_mobile || '-';

                const qrType = student.qr_type || 'permanent';
                qrTypeBadge.textContent = qrType === 'temporary' ? 'Temporary QR' : 'Permanent QR';
                qrTypeBadge.className = qrType === 'temporary'
                    ? 'badge bg-warning text-dark text-capitalize'
                    : 'badge bg-success text-capitalize';
            }

            function renderClasses(classes) {
                if (!classes || !classes.length) {
                    classTableBody.innerHTML = `
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">
                                        No active class details found for this student.
                                    </td>
                                </tr>
                            `;
                    return;
                }

                classTableBody.innerHTML = classes.map(item => `
                            <tr>
                                <td>${escapeHtml(item.class_name || '-')}</td>
                                <td>${escapeHtml(item.category_name || '-')}</td>
                                <td>${escapeHtml(item.teacher_initials || '-')}</td>
                                <td>${escapeHtml(item.grade || '-')}</td>
                                <td>${escapeHtml(item.subject || '-')}</td>
                                <td class="fw-bold">${formatMoney(item.final_fee)}</td>
                                <td>${renderAttendance(item.attendance)}</td>
                                <td>${renderLastPayment(item.last_payment)}</td>
                                <td>
                                    <button type="button"
                                        class="btn btn-sm btn-success custom-btn w-100"
                                        data-pay-enrollment-id="${escapeHtml(item.enrollment_id)}">
                                        Pay
                                    </button>
                                </td>
                            </tr>
                        `).join('');
            }

            function renderAttendance(attendance) {
                const attended = attendance?.attended_classes ?? 0;
                const total = attendance?.total_classes ?? 0;
                const percentage = attendance?.attendance_percentage ?? 0;
                const month = attendance?.month || '';

                return `
                            <div class="fw-bold">${attended} / ${total}</div>
                            <small class="text-muted">${percentage}% ${month ? '(' + escapeHtml(month) + ')' : ''}</small>
                        `;
            }

            function renderLastPayment(payment) {
                if (!payment) {
                    return '<span class="badge bg-danger">No Payment Yet</span>';
                }

                return `
                            <div class="fw-bold">${formatMoney(payment.amount)}</div>
                            <small class="text-muted">${escapeHtml(payment.payment_month || '-')}</small><br>
                            <small class="text-info">Receipt: ${escapeHtml(payment.receipt_number || '-')}</small>
                        `;
            }

            function openPaymentModal(enrollmentId) {
                if (!currentStudent) {
                    showAlert('warning', 'Please read a student first.');
                    return;
                }

                const selectedClass = currentClasses.find(item => String(item.enrollment_id) === String(enrollmentId));

                if (!selectedClass) {
                    showAlert('danger', 'Selected class details not found.');
                    return;
                }

                payStudentId.value = currentStudent.id;
                payEnrollmentId.value = selectedClass.enrollment_id;
                payClassName.textContent = `${selectedClass.class_name || '-'} - ${selectedClass.category_name || '-'}`;
                payMonth.value = getCurrentMonthValue();
                payAmount.value = selectedClass.final_fee || 0;
                payDiscount.value = 0;

                paymentModal?.show();
            }

            async function savePayment() {
                const studentIdValue = payStudentId.value;
                const enrollmentIdValue = payEnrollmentId.value;
                const amountValue = payAmount.value;
                const discountValue = payDiscount.value || 0;
                const monthValue = payMonth.value;

                if (!studentIdValue || !enrollmentIdValue) {
                    showAlert('danger', 'Payment details missing. Please select class again.');
                    return;
                }

                if (!monthValue) {
                    showAlert('warning', 'Please select payment month.');
                    payMonth.focus();
                    return;
                }

                if (!amountValue || Number(amountValue) <= 0) {
                    showAlert('warning', 'Please enter a valid payment amount.');
                    payAmount.focus();
                    return;
                }

                try {
                    savePaymentBtn.disabled = true;
                    savePaymentBtn.textContent = 'Saving...';

                    const response = await postJson(storePaymentApiUrl, {
                        student_id: studentIdValue,
                        student_class_enrollment_id: enrollmentIdValue,
                        amount: amountValue,
                        discount_amount: discountValue,
                        payment_month: monthValue
                    });

                    const result = response.result;

                    if (!response.ok || result.status !== 'success') {
                        showAlert('danger', getErrorMessage(response.status, result), result.errors || null);
                        return;
                    }

                    paymentModal?.hide();
                    showAlert('success', result.message || 'Payment saved successfully.');

                    if (currentQrCode) {
                        await readStudent(currentQrCode, 'manual', false);
                    }
                } catch (error) {
                    console.error('Save payment error:', error);
                    showAlert('danger', error.message || 'Something went wrong while saving payment.');
                } finally {
                    savePaymentBtn.disabled = false;
                    savePaymentBtn.textContent = 'Save Payment';
                }
            }

            function resetView() {
                currentStudent = null;
                currentClasses = [];
                currentQrCode = null;

                studentDetailsCard.classList.add('d-none');
                classDetailsCard.classList.add('d-none');
                emptyStateCard.classList.remove('d-none');
                hideErrorDetails();

                classTableBody.innerHTML = `
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No class details found.
                                </td>
                            </tr>
                        `;

                studentImage.src = defaultStudentImage;
                studentId.textContent = '-';
                studentName.textContent = '-';
                studentMobile.textContent = '-';
                guardianMobile.textContent = '-';
                qrTypeBadge.textContent = '-';
                qrTypeBadge.className = 'badge bg-secondary';
            }

            function getCurrentMonthValue() {
                const now = new Date();
                const year = now.getFullYear();
                const month = String(now.getMonth() + 1).padStart(2, '0');
                return `${year}-${month}`;
            }

            function formatMoney(value) {
                if (value === null || value === undefined || value === '') return '-';

                const numValue = Number(value);
                if (Number.isNaN(numValue)) return '-';

                return 'Rs. ' + numValue.toLocaleString('en-LK', {
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
                if (scannerRunning) {
                    showAlert('info', 'Scanner is already running.');
                    return;
                }

                if (typeof Html5Qrcode === 'undefined') {
                    showAlert('danger', 'QR scanner library failed to load.');
                    return;
                }

                if (!window.isSecureContext && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                    showAlert('danger', 'Camera scanner requires HTTPS or localhost. Manual entry can still be used.');
                    return;
                }

                try {
                    lastScannedCode = null;
                    lastScanTime = 0;
                    html5QrCode = new Html5Qrcode('qr-reader');

                    startScannerBtn.disabled = true;
                    startScannerBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Starting Scanner...';

                    await html5QrCode.start(
                        { facingMode: 'environment' },
                        {
                            fps: 10,
                            qrbox: function (viewfinderWidth, viewfinderHeight) {
                                const minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                                const qrboxSize = Math.floor(minEdge * 0.75);

                                return {
                                    width: Math.min(qrboxSize, 250),
                                    height: Math.min(qrboxSize, 250)
                                };
                            },
                            aspectRatio: 1.0,
                            rememberLastUsedCamera: true
                        },
                        function (decodedText) {
                            handleScannerSuccess(decodedText);
                        },
                        function () {
                            // ignore normal scan failures
                        }
                    );

                    scannerRunning = true;
                    startScannerBtn.innerHTML = '<i class="bi bi-camera-video-fill me-1"></i>Scanner Running';
                    startScannerBtn.disabled = true;
                    stopScannerBtn.classList.remove('d-none');

                    showAlert('success', 'Scanner started. Point the camera at a QR code.');
                } catch (error) {
                    console.error('Scanner start error:', error);
                    scannerRunning = false;
                    html5QrCode = null;
                    startScannerBtn.innerHTML = '<i class="bi bi-camera-fill me-1"></i>Start Scanner';
                    startScannerBtn.disabled = false;
                    stopScannerBtn.classList.add('d-none');
                    showAlert('danger', getScannerErrorMessage(error));
                }
            }

            function handleScannerSuccess(decodedText) {
                const code = String(decodedText || '').trim();
                const now = Date.now();

                if (!code) return;
                if (processingRequest) return;

                if (code === lastScannedCode && now - lastScanTime < SCAN_COOLDOWN_MS) {
                    return;
                }

                lastScannedCode = code;
                lastScanTime = now;

                readStudent(code, 'scanner');
            }

            function getScannerErrorMessage(error) {
                const name = error?.name || '';
                const message = error?.message || String(error || '');

                if (name === 'NotAllowedError' || message.includes('Permission')) {
                    return 'Camera permission denied. Please allow camera access and try again.';
                }

                if (name === 'NotFoundError' || message.includes('Requested device not found')) {
                    return 'No camera found on this device.';
                }

                if (name === 'NotReadableError') {
                    return 'Camera is already in use by another app or browser tab.';
                }

                return message || 'Could not start scanner. Please use manual entry.';
            }

            async function stopScanner(showMessage = true) {
                if (html5QrCode && scannerRunning) {
                    try {
                        await html5QrCode.stop();
                        await html5QrCode.clear();
                    } catch (error) {
                        console.debug('Error stopping scanner:', error);
                    }
                }

                scannerRunning = false;
                html5QrCode = null;
                lastScannedCode = null;
                lastScanTime = 0;

                startScannerBtn.disabled = false;
                startScannerBtn.innerHTML = '<i class="bi bi-camera-fill me-1"></i>Start Scanner';
                stopScannerBtn.classList.add('d-none');

                if (showMessage) {
                    showAlert('info', 'Scanner stopped.');
                }
            }

            if (startScannerBtn) {
                startScannerBtn.addEventListener('click', startScanner);
            }

            if (stopScannerBtn) {
                stopScannerBtn.addEventListener('click', function () {
                    stopScanner(true);
                });
            }

            if (manualQrForm) {
                manualQrForm.addEventListener('submit', function (event) {
                    event.preventDefault();

                    const code = manualQrCode ? manualQrCode.value.trim() : '';

                    if (!code) {
                        showAlert('warning', 'Please enter a QR code.');
                        manualQrCode?.focus();
                        return;
                    }

                    readStudent(code, 'manual');
                });
            }

            if (paymentForm) {
                paymentForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    savePayment();
                });
            }

            if (classTableBody) {
                classTableBody.addEventListener('click', function (event) {
                    const payButton = event.target.closest('[data-pay-enrollment-id]');

                    if (!payButton) return;

                    openPaymentModal(payButton.getAttribute('data-pay-enrollment-id'));
                });
            }

            if (manualTabBtn) {
                manualTabBtn.addEventListener('shown.bs.tab', function () {
                    manualQrCode?.focus();
                });
            }

            window.addEventListener('beforeunload', function () {
                if (html5QrCode && scannerRunning) {
                    html5QrCode.stop().catch(function () { });
                }
            });
        });
    </script>
@endpush