@extends('layouts.app')

@section('title', 'Payment Details')
@section('page-title', 'Payment Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('student-payment.create') }}">Add Payment</a></li>
    <li class="breadcrumb-item active">Payment Details</li>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container-fluid">
        <!-- Student Information Card -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-graduate me-2"></i>Student Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row" id="studentInfo">
                    <div class="col-md-12 text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading student information...</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Summary -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0" id="totalPaid">LKR 0</h4>
                                <p class="mb-0">Total Paid</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0" id="totalPayments">0</h4>
                                <p class="mb-0">Total Payments</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-receipt fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h4 class="mb-0" id="activePayments">0</h4>
                                <p class="mb-0">Active Payments</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-filter me-2"></i>Filter Payments
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="monthFilter" class="form-label">Month</label>
                        <select class="form-select" id="monthFilter">
                            <option value="all">All Months</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Payment Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="all">All Status</option>
                            <option value="true">Active (True)</option>
                            <option value="false">Deleted (False)</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="searchFilter" class="form-label">Search</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchFilter" placeholder="Search payments...">
                            <button class="btn btn-outline-secondary" type="button" id="clearFilters">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100" id="refreshPayments">
                            <i class="fas fa-sync-alt me-1"></i>Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Payment View -->
        <div class="card">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar-alt me-2"></i>Payment History
                </h5>
                <div class="filter-info" id="filterInfo" style="display: none;">
                    <small>Showing filtered results</small>
                </div>
            </div>
            <div class="card-body">
                <div id="paymentsContainer">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading payment history...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Global variables
        let studentId = {{ $student_id }};
        let studentClassId = {{ $student_class_id }};
        let allPaymentData = [];
        let filteredPaymentData = [];

        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            window.csrfToken = csrfToken;

            fetchStudentInfo(studentId);
            fetchPaymentData(studentId, studentClassId);

            document.getElementById('monthFilter').addEventListener('change', applyFilters);
            document.getElementById('statusFilter').addEventListener('change', applyFilters);
            document.getElementById('searchFilter').addEventListener('input', applyFilters);
            document.getElementById('clearFilters').addEventListener('click', clearFilters);
            document.getElementById('refreshPayments').addEventListener('click', function () {
                fetchPaymentData(studentId, studentClassId);
            });
        });

        function getBooleanValue(value) {
            if (typeof value === 'boolean') return value;
            if (typeof value === 'number') return value === 1;
            if (typeof value === 'string') {
                if (value.toLowerCase() === 'true') return true;
                if (value.toLowerCase() === 'false') return false;
                return value === '1';
            }
            return false;
        }

        function parseLaravelDateTime(dateString) {
            if (!dateString || typeof dateString !== 'string') return null;

            const normalized = dateString.trim().replace('T', ' ').split('.')[0];
            const parts = normalized.split(' ');

            if (parts.length < 2) return null;

            const [datePart, timePart] = parts;
            const [year, month, day] = datePart.split('-').map(Number);
            const [hour, minute, second] = timePart.split(':').map(Number);

            if (
                !year || !month || !day ||
                hour === undefined || minute === undefined || second === undefined
            ) {
                return null;
            }

            return new Date(year, month - 1, day, hour, minute, second);
        }

        // ✅ නිවැරදි කළ function - YYYY-MM-DD HH:MM format එකෙන් පෙන්වන්න
        function formatDateTimeToSriLankan(dateString) {
            if (!dateString) return 'N/A';

            try {
                let year, month, day, hour, minute;

                // Format 1: "2026-04-22 21:23:49"
                if (dateString.includes(' ') && dateString.match(/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/)) {
                    const [datePart, timePart] = dateString.split(' ');
                    [year, month, day] = datePart.split('-');
                    [hour, minute] = timePart.split(':');

                    return `${year}-${month}-${day} ${hour}:${minute}`;
                }

                // Format 2: "2026-04-22T21:23:49.000000Z" (ISO format)
                if (dateString.includes('T')) {
                    const date = new Date(dateString);
                    if (!isNaN(date.getTime())) {
                        year = date.getFullYear();
                        month = String(date.getMonth() + 1).padStart(2, '0');
                        day = String(date.getDate()).padStart(2, '0');
                        hour = String(date.getHours()).padStart(2, '0');
                        minute = String(date.getMinutes()).padStart(2, '0');

                        return `${year}-${month}-${day} ${hour}:${minute}`;
                    }
                }

                // Format 3: "2026-04-22" (date only)
                if (dateString.match(/\d{4}-\d{2}-\d{2}/) && !dateString.includes(' ')) {
                    return `${dateString} 00:00`;
                }

                return dateString;
            } catch (error) {
                console.error('Error formatting date:', error);
                return dateString;
            }
        }

        function fetchStudentInfo(studentId) {
            fetch(`/api/student-classes/student/${studentId}/filter`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success' && data.data.length > 0) {
                        displayStudentInfo(data.data[0]);
                    }
                })
                .catch(error => {
                    console.error('Error fetching student info:', error);
                    document.getElementById('studentInfo').innerHTML = `
                        <div class="col-md-12 text-center text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>Failed to load student information</p>
                        </div>
                    `;
                });
        }

        function displayStudentInfo(studentData) {
            const student = studentData.student;
            const studentStatus = getBooleanValue(student.student_status);
            const statusText = studentStatus ? 'Active' : 'Inactive';
            const statusClass = studentStatus ? 'bg-success' : 'bg-danger';

            document.getElementById('studentInfo').innerHTML = `
                <div class="col-md-2 text-center">
                    <img src="${student.img_url || '/uploads/logo/logo.png'}" alt="Student Photo" 
                         class="img-thumbnail rounded-circle" style="width: 80px; height: 80px; object-fit: cover;"
                         onerror="this.src='/uploads/logo/logo.png'">
                </div>
                <div class="col-md-5">
                    <h5>${student.last_name || student.first_name || 'N/A'}</h5>
                    <p class="mb-1"><strong>Student ID:</strong> ${student.student_custom_id || 'N/A'}</p>
                    <p class="mb-1"><strong>Guardian Mobile:</strong> ${student.guardian_mobile || 'N/A'}</p>
                    <p class="mb-1"><strong>Class:</strong> ${studentData.student_class?.class_name || 'N/A'}</p>
                </div>
                <div class="col-md-5">
                    <p class="mb-1"><strong>Subject:</strong> ${studentData.student_class?.subject?.subject_name || 'N/A'}</p>
                    <p class="mb-1"><strong>Teacher:</strong> ${studentData.student_class?.teacher?.first_name || 'N/A'}</p>
                    <p class="mb-0"><strong>Status:</strong> 
                        <span class="badge ${statusClass}">
                            ${statusText}
                        </span>
                    </p>
                </div>
            `;
        }

        function fetchPaymentData(studentId, studentClassId) {
            const paymentsContainer = document.getElementById('paymentsContainer');
            paymentsContainer.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading payment history...</p>
                </div>
            `;

            fetch(`/api/payments/${studentId}/${studentClassId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // ✅ Console එකේ payment data log කරන්න
                        console.log('=== Payment Data from API ===');
                        console.log('Full Response:', data);
                        console.log('Monthly View:', data.data.monthly_view);
                        
                        // ✅ එක් එක් payment එකේ payment_date log කරන්න
                        if (data.data.monthly_view && data.data.monthly_view.length > 0) {
                            data.data.monthly_view.forEach((month, monthIndex) => {
                                console.log(`Month ${monthIndex + 1}: ${month.month}`);
                                if (month.payments && month.payments.length > 0) {
                                    month.payments.forEach((payment, paymentIndex) => {
                                        console.log(`  Payment ${paymentIndex + 1}:`);
                                        console.log(`    ID: ${payment.id}`);
                                        console.log(`    payment_date: ${payment.payment_date}`);
                                        console.log(`    created_at: ${payment.created_at}`);
                                        console.log(`    payment_for: ${payment.payment_for}`);
                                        console.log(`    amount: ${payment.amount}`);
                                        console.log(`    status: ${payment.status}`);
                                    });
                                }
                            });
                        }
                        
                        allPaymentData = processPaymentData(data.data.monthly_view);
                        filteredPaymentData = [...allPaymentData];
                        displayPaymentSummary(data.data.summary);
                        displayMonthlyPayments(allPaymentData);
                        populateMonthFilter(allPaymentData);
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error fetching payments:', error);
                    paymentsContainer.innerHTML = `
                        <div class="text-center py-4 text-danger">
                            <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                            <p>Failed to load payment history</p>
                            <small class="text-muted">${error.message}</small>
                        </div>
                    `;
                });
        }

        function processPaymentData(monthlyData) {
            return monthlyData.map(month => ({
                ...month,
                year_month: month.year_month,
                month: month.month,
                total_amount: month.total_amount,
                payment_count: month.payment_count,
                payments: month.payments.map(payment => {
                    // ✅ Console එකේ formatted payment_date එක log කරන්න
                    const formattedDate = formatDateTimeToSriLankan(payment.payment_date);
                    console.log(`Processing Payment ID ${payment.id}: Original: ${payment.payment_date} -> Formatted: ${formattedDate}`);
                    
                    return {
                        ...payment,
                        status: getBooleanValue(payment.status),
                        status_text: getBooleanValue(payment.status) ? 'Active' : 'Deleted',
                        created_at: payment.created_at || payment.payment_date,
                        payment_date: payment.payment_date,
                        display_date: formattedDate
                    };
                })
            }));
        }

        function displayPaymentSummary(summary) {
            document.getElementById('totalPaid').textContent = `LKR ${(summary.total_paid || 0).toLocaleString('en-LK')}`;
            document.getElementById('totalPayments').textContent = summary.total_payments || 0;
            document.getElementById('activePayments').textContent = summary.active_payments || '0';
        }

        function populateMonthFilter(monthlyData) {
            const monthFilter = document.getElementById('monthFilter');
            let options = '<option value="all">All Months</option>';

            monthlyData.forEach(month => {
                options += `<option value="${month.year_month}">${month.month}</option>`;
            });

            monthFilter.innerHTML = options;
        }

        function applyFilters() {
            const monthFilter = document.getElementById('monthFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const searchFilter = document.getElementById('searchFilter').value.toLowerCase();

            filteredPaymentData = allPaymentData.filter(month => {
                if (monthFilter !== 'all' && month.year_month !== monthFilter) {
                    return false;
                }

                const filteredPayments = month.payments.filter(payment => {
                    if (statusFilter !== 'all') {
                        const filterBoolean = statusFilter === 'true';
                        if (payment.status !== filterBoolean) {
                            return false;
                        }
                    }

                    if (searchFilter && !payment.payment_for.toLowerCase().includes(searchFilter)) {
                        return false;
                    }

                    return true;
                });

                month.filteredPayments = filteredPayments;
                return filteredPayments.length > 0;
            });

            displayMonthlyPayments(filteredPaymentData);
            updateFilterInfo();
        }

        function clearFilters() {
            document.getElementById('monthFilter').value = 'all';
            document.getElementById('statusFilter').value = 'all';
            document.getElementById('searchFilter').value = '';

            filteredPaymentData = [...allPaymentData];
            displayMonthlyPayments(allPaymentData);
            document.getElementById('filterInfo').style.display = 'none';
        }

        function updateFilterInfo() {
            const filterInfo = document.getElementById('filterInfo');
            const monthFilter = document.getElementById('monthFilter').value;
            const statusFilter = document.getElementById('statusFilter').value;
            const searchFilter = document.getElementById('searchFilter').value;

            const activeFilters = [];

            if (monthFilter !== 'all') {
                const monthName = document.getElementById('monthFilter').options[document.getElementById('monthFilter').selectedIndex].text;
                activeFilters.push(`Month: ${monthName}`);
            }

            if (statusFilter !== 'all') {
                const statusName = document.getElementById('statusFilter').options[document.getElementById('statusFilter').selectedIndex].text;
                activeFilters.push(`Status: ${statusName}`);
            }

            if (searchFilter) {
                activeFilters.push(`Search: "${searchFilter}"`);
            }

            if (activeFilters.length > 0) {
                filterInfo.innerHTML = `<small>${activeFilters.join(' • ')}</small>`;
                filterInfo.style.display = 'block';
            } else {
                filterInfo.style.display = 'none';
            }
        }

        function displayMonthlyPayments(monthlyData) {
            const paymentsContainer = document.getElementById('paymentsContainer');

            if (monthlyData.length === 0) {
                paymentsContainer.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No Payments Found</h5>
                        <p class="text-muted">No payments match your filter criteria.</p>
                        <button class="btn btn-primary mt-2" onclick="clearFilters()">
                            <i class="fas fa-times me-1"></i>Clear Filters
                        </button>
                    </div>
                `;
                return;
            }

            let html = '';

            monthlyData.forEach(month => {
                const paymentsToShow = month.filteredPayments || month.payments;

                html += `
                    <div class="month-section mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3 p-3 bg-light rounded">
                            <h5 class="mb-0">
                                <i class="fas fa-calendar me-2"></i>${month.month}
                            </h5>
                            <div class="text-end">
                                <span class="badge bg-primary fs-6">
                                    LKR ${(month.total_amount || 0).toLocaleString('en-LK')}
                                </span>
                                <small class="text-muted d-block">${month.payment_count} payment(s)</small>
                            </div>
                        </div>

                        <div class="row g-3">
                `;

                paymentsToShow.forEach(payment => {
                    const statusClass = payment.status === true ? 'bg-success' : 'bg-danger';
                    const statusText = payment.status === true ? 'Active' : 'Deleted';
                    const canDelete = payment.status === true ? isPaymentWithin7Days(payment.created_at) : false;

                    html += `
                        <div class="col-md-6 col-lg-4">
                            <div class="card payment-card h-100 ${payment.status === false ? 'opacity-75' : ''}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="card-title mb-0">${payment.payment_for}</h6>
                                        <div class="text-end">
                                            <span class="badge ${statusClass}">${statusText}</span>
                                        </div>
                                    </div>
                                    <p class="card-text mb-1">
                                        <i class="fas fa-calendar me-2 text-muted"></i>
                                        ${payment.display_date}
                                    </p>
                                    <p class="card-text mb-2">
                                        <i class="fas fa-money-bill me-2 text-muted"></i>
                                        <strong class="text-success">LKR ${(payment.amount || 0).toLocaleString('en-LK')}</strong>
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">ID: ${payment.id}</small>
                                        ${canDelete ? `
                                            <button class="btn btn-outline-danger btn-sm btn-delete-payment" 
                                                    data-payment-id="${payment.id}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        ` : (payment.status === true ? '<small class="text-muted">Delete period expired</small>' : '')}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                html += `
                        </div>
                    </div>
                `;
            });

            paymentsContainer.innerHTML = html;
            addDeleteEventListeners();
        }

        function isPaymentWithin7Days(paymentDate) {
            if (!paymentDate) return false;

            const paymentDateTime = parseLaravelDateTime(paymentDate);
            if (!paymentDateTime || isNaN(paymentDateTime.getTime())) return false;

            const currentTime = new Date();
            const timeDifference = currentTime - paymentDateTime;
            const daysDifference = timeDifference / (1000 * 60 * 60 * 24);

            return daysDifference <= 7;
        }

        function addDeleteEventListeners() {
            document.querySelectorAll('.btn-delete-payment').forEach(btn => {
                btn.addEventListener('click', function () {
                    const paymentId = this.getAttribute('data-payment-id');
                    deletePayment(paymentId);
                });
            });
        }

        function deletePayment(paymentId) {
            if (!confirm('Are you sure you want to delete this payment? This action cannot be undone.')) {
                return;
            }

            fetch(`/api/payments/${paymentId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': window.csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        showAlert('Payment deleted successfully!', 'success');
                        fetchPaymentData(studentId, studentClassId);
                    } else {
                        throw new Error(data.message || 'Delete failed');
                    }
                })
                .catch(error => {
                    console.error('Delete error:', error);
                    showAlert('Delete error: ' + error.message, 'danger');
                });
        }

        function showAlert(message, type) {
            document.querySelectorAll('.alert-dismissible').forEach(alert => alert.remove());

            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            document.body.appendChild(alertDiv);

            setTimeout(() => {
                if (alertDiv.parentNode) {
                    alertDiv.remove();
                }
            }, 5000);
        }
    </script>

    <style>
        .payment-card {
            border: 1px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .payment-card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .month-section {
            border-bottom: 2px solid #f8f9fa;
            padding-bottom: 20px;
        }

        .month-section:last-child {
            border-bottom: none;
        }

        .card.bg-success,
        .card.bg-info,
        .card.bg-warning {
            border: none;
            border-radius: 10px;
        }

        .icon {
            opacity: 0.8;
        }

        .filter-info {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 10px;
            border-radius: 5px;
        }

        .btn-group-sm .btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .payment-card .badge.bg-info {
            font-size: 0.7rem;
        }

        .payment-card .badge.bg-secondary {
            font-size: 0.7rem;
        }
    </style>
@endpush