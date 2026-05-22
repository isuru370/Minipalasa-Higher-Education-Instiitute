@extends('layouts.app')

@section('title', 'Manage Class Categories & Fees')
@section('page-title', 'Manage Categories & Fees')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('class_rooms.index') }}">Class Rooms</a></li>
    <li class="breadcrumb-item active">Manage Categories & Fees</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags me-2"></i>Manage Categories & Fees for Class ID: {{ $id }}
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Class Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="class-info p-3 bg-light rounded">
                                <h6 class="fw-bold">Class Details:</h6>
                                <div id="classDetails">
                                    <div class="text-center py-2">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <span class="ms-2">Loading class information...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="{{ route('class_rooms.schedule') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Classes
                            </a>
                        </div>
                    </div>

                    <!-- Add Category & Fees Form with Payment Config -->
                    <div class="card mb-4">
                        <div class="card-header bg-transparent">
                            <h6 class="card-title mb-0">Add Category & Set Fee with Payment Configuration</h6>
                        </div>
                        <div class="card-body">
                            <form id="addCategoryFeeForm">
                                @csrf
                                <input type="hidden" name="student_classes_id" value="{{ $id }}">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="class_category_id" class="form-label">
                                                Category <span class="text-danger">*</span>
                                            </label>
                                            <select class="form-select" id="class_category_id" name="class_category_id"
                                                required>
                                                <option value="">Select Category</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="fees" class="form-label">
                                                Fee Amount (Rs.) <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" class="form-control" id="fees" name="fees" min="0"
                                                step="0.01" placeholder="0.00" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Payment Configuration Section -->
                                <div class="card bg-light mb-3">
                                    <div class="card-header bg-secondary text-white">
                                        <h6 class="mb-0">Payment Configuration</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="teacher_percentage" class="form-label">
                                                        Teacher Percentage (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" class="form-control" id="teacher_percentage"
                                                        name="teacher_percentage" min="0" max="100" step="0.01"
                                                        placeholder="e.g., 50" required>
                                                    <small class="text-muted">Percentage for teacher</small>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="organizer_percentage" class="form-label">
                                                        Organizer Percentage (%)
                                                    </label>
                                                    <input type="number" class="form-control" id="organizer_percentage"
                                                        name="organizer_percentage" min="0" max="100" step="0.01"
                                                        placeholder="e.g., 20" value="0">
                                                    <small class="text-muted">Percentage for organizer (optional)</small>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="institution_percentage" class="form-label">
                                                        Institution Percentage (%) <span class="text-danger">*</span>
                                                    </label>
                                                    <input type="number" class="form-control" id="institution_percentage"
                                                        name="institution_percentage" min="0" max="100" step="0.01"
                                                        placeholder="e.g., 30" required>
                                                    <small class="text-muted">Percentage for institution</small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="alert alert-info" id="percentageTotalAlert">
                                            <i class="fas fa-info-circle me-2"></i>
                                            Total Percentage: <span id="totalPercentageDisplay">0</span>%
                                            <span id="percentageValidationMsg"></span>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="organizer_id" class="form-label">Organizer</label>
                                                    <select class="form-select" id="organizer_id" name="organizer_id">
                                                        <option value="">Select Organizer (Optional)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="effective_from" class="form-label">Effective From</label>
                                                    <input type="date" class="form-control" id="effective_from"
                                                        name="effective_from">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <label for="effective_to" class="form-label">Effective To</label>
                                                    <input type="date" class="form-control" id="effective_to"
                                                        name="effective_to">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-check mb-3">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                                value="1" checked>
                                            <label class="form-check-label" for="is_active">
                                                Active Payment Configuration
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary w-100" id="addCategoryFeeBtn">
                                            <i class="fas fa-plus me-2"></i>Add Category & Configure Payment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Assigned Categories Table -->
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="card-title mb-0">Assigned Categories & Fees</h6>
                                <button class="btn btn-outline-primary btn-sm" onclick="loadAssignedCategories()"
                                    title="Refresh">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-primary">
                                        <tr>
                                            <th width="40">#</th>
                                            <th>Category Name</th>
                                            <th class="text-end">Fee Amount</th>
                                            <th class="text-center">Teacher %</th>
                                            <th class="text-center">Organizer %</th>
                                            <th class="text-center">Institution %</th>
                                            <th class="text-center">Status</th>
                                            <th width="170" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="assignedCategoriesTableBody"></tbody>
                                </table>
                            </div>

                            <!-- Loading State -->
                            <div id="assignedCategoriesLoading" class="text-center py-4">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <p class="mt-2 text-muted">Loading assigned categories...</p>
                            </div>

                            <!-- Empty State -->
                            <div id="assignedCategoriesEmpty" class="text-center py-5 d-none">
                                <div class="empty-state-icon">
                                    <i class="fas fa-tags fa-4x text-muted mb-4"></i>
                                </div>
                                <h4 class="text-muted">No Categories Assigned</h4>
                                <p class="text-muted mb-4">No categories have been assigned to this class yet.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Fee Modal -->
    <div class="modal fade" id="editCategoryFeeModal" tabindex="-1" aria-labelledby="editCategoryFeeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editCategoryFeeModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Category Fee
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form id="editCategoryFeeForm">
                        <input type="hidden" id="edit_category_class_id">
                        <input type="hidden" id="edit_category_id">

                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <div class="form-control bg-light" id="edit_category_name_display" style="border: none;"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Fee</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rs.</span>
                                <input type="text" class="form-control bg-light" id="edit_current_fee" readonly
                                    style="border: none;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="edit_new_fee" class="form-label">
                                New Fee Amount <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" class="form-control" id="edit_new_fee" name="fees" min="0" step="0.01"
                                    placeholder="0.00" required>
                            </div>
                            <div class="form-text">Enter the new fee amount for this category</div>
                            <div class="invalid-feedback" id="edit_new_fee_error"></div>
                        </div>

                        <div class="alert alert-info d-none" id="feeChangeSummary">
                            <div class="d-flex justify-content-between">
                                <span>Old Fee:</span>
                                <span id="oldFeeAmount" class="fw-bold"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>New Fee:</span>
                                <span id="newFeeAmount" class="fw-bold"></span>
                            </div>
                            <div class="d-flex justify-content-between border-top mt-2 pt-2">
                                <span>Difference:</span>
                                <span id="feeDifference" class="fw-bold"></span>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-warning" id="updateCategoryFeeBtn">
                        <i class="fas fa-save me-2"></i>Update Fee
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .card-header.bg-transparent {
            background: transparent !important;
            border-bottom: 1px solid #dee2e6;
        }

        .table th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            font-weight: 600;
            border: none;
        }

        .table td {
            vertical-align: middle;
            border-color: #f8f9fa;
        }

        .btn {
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .empty-state-icon {
            opacity: 0.5;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const classId = {{ $id }};

        document.addEventListener('DOMContentLoaded', function () {
            loadClassDetails();
            loadCategoriesDropdown();
            loadOrganizersDropdown();
            loadAssignedCategories();

            document.getElementById('addCategoryFeeForm').addEventListener('submit', function (e) {
                e.preventDefault();
                addCategoryFee();
            });

            const teacherPercent = document.getElementById('teacher_percentage');
            const organizerPercent = document.getElementById('organizer_percentage');
            const institutionPercent = document.getElementById('institution_percentage');

            [teacherPercent, organizerPercent, institutionPercent].forEach(input => {
                if (input) {
                    input.addEventListener('input', calculateTotalPercentage);
                    input.addEventListener('blur', calculateTotalPercentage);
                }
            });

            const updateCategoryFeeBtn = document.getElementById('updateCategoryFeeBtn');
            if (updateCategoryFeeBtn) {
                updateCategoryFeeBtn.addEventListener('click', updateCategoryFee);
            }

            const editCategoryFeeModal = document.getElementById('editCategoryFeeModal');
            if (editCategoryFeeModal) {
                editCategoryFeeModal.addEventListener('hidden.bs.modal', function () {
                    document.getElementById('editCategoryFeeForm').reset();
                    document.getElementById('feeChangeSummary').classList.add('d-none');
                    document.getElementById('edit_new_fee').classList.remove('is-invalid');
                    document.getElementById('edit_new_fee_error').textContent = '';
                });
            }

            const editNewFeeInput = document.getElementById('edit_new_fee');
            if (editNewFeeInput) {
                editNewFeeInput.addEventListener('input', updateFeeChangeSummary);
            }
        });

        function calculateTotalPercentage() {
            const teacher = parseFloat(document.getElementById('teacher_percentage')?.value) || 0;
            const organizer = parseFloat(document.getElementById('organizer_percentage')?.value) || 0;
            const institution = parseFloat(document.getElementById('institution_percentage')?.value) || 0;

            const total = teacher + organizer + institution;
            const totalDisplay = document.getElementById('totalPercentageDisplay');
            const validationMsg = document.getElementById('percentageValidationMsg');

            if (totalDisplay) totalDisplay.textContent = total.toFixed(2);

            if (Math.abs(total - 100) > 0.01) {
                if (validationMsg) {
                    validationMsg.innerHTML = `<span class="text-danger ms-2">⚠️ Must total 100% (Current: ${total.toFixed(2)}%)</span>`;
                }
                return false;
            } else {
                if (validationMsg) {
                    validationMsg.innerHTML = `<span class="text-success ms-2">✓ Perfect!</span>`;
                }
                return true;
            }
        }

        function loadClassDetails() {
            fetch(`/api/class-rooms/${classId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        const classData = data.data;
                        document.getElementById('classDetails').innerHTML = `
                                        <p class="mb-1"><strong>Class Name:</strong> ${classData.class_name || 'N/A'}</p>
                                        <p class="mb-1"><strong>Teacher:</strong> ${classData.teacher ? classData.teacher.fname + ' ' + classData.teacher.lname : 'N/A'}</p>
                                        <p class="mb-1"><strong>Subject:</strong> ${classData.subject ? classData.subject.subject_name : 'N/A'}</p>
                                        <p class="mb-0"><strong>Class ID:</strong> ${classId}</p>
                                    `;
                    }
                })
                .catch(error => {
                    console.error('Error loading class details:', error);
                });
        }

        function loadCategoriesDropdown() {
            fetch('/api/categories/dropdown')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const select = document.getElementById('class_category_id');
                    select.innerHTML = '<option value="">Select Category</option>';

                    if (data.status === 'success' && data.data) {
                        data.data.forEach(cat => {
                            select.innerHTML += `<option value="${cat.id}">${cat.category_name}</option>`;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error loading categories:', error);
                });
        }

        function loadOrganizersDropdown() {
            fetch('{{ route("organizers.dropdown") }}')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    const select = document.getElementById('organizer_id');
                    let options = '<option value="">Select Organizer (Optional)</option>';

                    if (data.status === 'success' && data.data) {
                        data.data.forEach(org => {
                            options += `<option value="${org.id}">${org.name || org.organizer_name}</option>`;
                        });
                    }

                    select.innerHTML = options;
                })
                .catch(error => {
                    console.error('Error loading organizers:', error);
                });
        }

        async function addCategoryFee() {
            if (!calculateTotalPercentage()) {
                showAlert('Percentages must total 100%!', 'danger');
                return;
            }

            const btn = document.getElementById('addCategoryFeeBtn');
            const originalText = btn.innerHTML;

            const formData = {
                student_classes_id: classId,
                class_category_id: document.getElementById('class_category_id').value,
                fees: parseFloat(document.getElementById('fees').value),
                teacher_percentage: parseFloat(document.getElementById('teacher_percentage').value),
                organizer_percentage: parseFloat(document.getElementById('organizer_percentage').value) || 0,
                institution_percentage: parseFloat(document.getElementById('institution_percentage').value),
                organizer_id: document.getElementById('organizer_id').value || null,
                effective_from: document.getElementById('effective_from').value || null,
                effective_to: document.getElementById('effective_to').value || null,
                is_active: document.getElementById('is_active').checked ? 1 : 0
            };

            if (!formData.class_category_id) {
                showAlert('Please select a category', 'warning');
                return;
            }

            if (!formData.fees || formData.fees <= 0) {
                showAlert('Please enter a valid fee amount', 'warning');
                return;
            }

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';

            try {
                const response = await fetch('/api/class-has-category-classes', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || `HTTP ${response.status}`);
                }

                if (data.status === 'success') {
                    document.getElementById('addCategoryFeeForm').reset();
                    document.getElementById('teacher_percentage').value = '';
                    document.getElementById('institution_percentage').value = '';
                    document.getElementById('organizer_percentage').value = '0';
                    document.getElementById('is_active').checked = true;
                    calculateTotalPercentage();
                    loadAssignedCategories();
                    showAlert('Category and payment configuration added successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to add');
                }
            } catch (error) {
                console.error('Error:', error);
                showAlert('Error: ' + error.message, 'danger');
            } finally {
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }

        function loadAssignedCategories() {
            const loading = document.getElementById('assignedCategoriesLoading');
            const tableResponsive = document.querySelector('.table-responsive');

            if (loading) loading.classList.remove('d-none');
            if (tableResponsive) tableResponsive.classList.add('d-none');

            fetch(`/api/class-has-category-classes/class-category-class/${classId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    let items = [];

                    if (data.status === 'success' && data.data) {
                        items = data.data;
                    } else if (Array.isArray(data)) {
                        items = data;
                    }

                    renderTable(items);
                })
                .catch(error => {
                    console.error('Error loading assigned categories:', error);
                    showAlert('Error loading assigned categories: ' + error.message, 'danger');
                    const tbody = document.getElementById('assignedCategoriesTableBody');
                    if (tbody) {
                        tbody.innerHTML = '<tr><td colspan="8" class="text-center text-danger">Failed to load data</td></tr>';
                    }
                })
                .finally(() => {
                    if (loading) loading.classList.add('d-none');
                    if (tableResponsive) tableResponsive.classList.remove('d-none');
                });
        }

        function renderTable(items) {
            const tbody = document.getElementById('assignedCategoriesTableBody');
            const emptyState = document.getElementById('assignedCategoriesEmpty');

            if (!tbody) return;

            if (!items || items.length === 0) {
                tbody.innerHTML = '';
                if (emptyState) emptyState.classList.remove('d-none');
                return;
            }

            if (emptyState) emptyState.classList.add('d-none');
            tbody.innerHTML = '';

            items.forEach((item, index) => {
                const paymentConfig = item.active_payment_config || item.payment_config || {};
                const isActive = item.status == 1;
                const categoryName = item.class_category?.category_name || item.category_name || 'N/A';
                const fees = parseFloat(item.fees || item.fee || 0).toFixed(2);
                const hasPlusMark = categoryName.includes('+');

                const row = `
                    <tr>
                        <td class="text-center">${index + 1}</td>
                        <td>${escapeHtml(categoryName)}</td>
                        <td class="text-end"><span class="badge bg-success">Rs. ${fees}</span></td>
                        <td class="text-center"><span class="badge bg-info">${paymentConfig.teacher_percentage ?? 0}%</span></td>
                        <td class="text-center"><span class="badge bg-warning">${paymentConfig.organizer_percentage ?? 0}%</span></td>
                        <td class="text-center"><span class="badge bg-secondary">${paymentConfig.institution_percentage ?? 0}%</span></td>
                        <td class="text-center">
                            <span class="badge ${isActive ? 'bg-success' : 'bg-danger'}">
                                ${isActive ? 'Active' : 'Inactive'}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-warning" title="Edit Fee"
                                    onclick="editCategoryFee(
                                        ${item.id},
                                        ${item.class_category_id},
                                        ${parseFloat(item.fees || 0)},
                                        '${escapeHtml(categoryName)}'
                                    )">
                                    <i class="fas fa-edit"></i>
                                </button>

                                ${!hasPlusMark ? `
                                <button class="btn btn-outline-primary" title="View Category Details"
                                    onclick="viewCategoryDetails(
                                        ${item.id},
                                        ${item.class_category_id},
                                        '${escapeHtml(categoryName)}'
                                    )">
                                    <i class="fas fa-eye"></i>
                                </button>
                                ` : ''}

                                ${!hasPlusMark ? `
                                <button class="btn btn-outline-info" title="Manage Schedule"
                                    onclick="manageCategorySchedule(
                                        ${item.id},
                                        ${item.class_category_id},
                                        '${escapeHtml(categoryName)}'
                                    )">
                                    <i class="fas fa-calendar-alt"></i>
                                </button>
                                ` : ''}

                                <button class="btn ${isActive ? 'btn-outline-danger' : 'btn-outline-success'}"
                                    title="${isActive ? 'Deactivate' : 'Activate'}"
                                    onclick="toggleCategoryStatus(${item.id}, ${isActive ? 1 : 0})">
                                    <i class="fas ${isActive ? 'fa-trash' : 'fa-rotate-left'}"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;

                tbody.innerHTML += row;
            });
        }

        function editCategoryFee(classCategoryHasStudentClassId, categoryId, currentFee, categoryName) {
            document.getElementById('edit_category_class_id').value = classCategoryHasStudentClassId;
            document.getElementById('edit_category_id').value = categoryId;
            document.getElementById('edit_current_fee').value = currentFee.toFixed(2);
            document.getElementById('edit_new_fee').value = currentFee.toFixed(2);
            document.getElementById('edit_category_name_display').textContent = categoryName;

            const modal = new bootstrap.Modal(document.getElementById('editCategoryFeeModal'));
            modal.show();
        }

        function viewCategoryDetails(classCategoryHasStudentClassId, categoryId, categoryName) {
            window.location.href = `/class-attendances/${classCategoryHasStudentClassId}`;
        }

        function manageCategorySchedule(classCategoryHasStudentClassId, categoryId, categoryName) {
            window.location.href = `/class-attendances/create/${classCategoryHasStudentClassId}`;
        }

        function updateFeeChangeSummary() {
            const currentFee = parseFloat(document.getElementById('edit_current_fee').value);
            const newFeeInput = document.getElementById('edit_new_fee');
            const newFee = parseFloat(newFeeInput.value) || 0;

            const feeChangeSummary = document.getElementById('feeChangeSummary');
            const oldFeeAmount = document.getElementById('oldFeeAmount');
            const newFeeAmount = document.getElementById('newFeeAmount');
            const feeDifference = document.getElementById('feeDifference');

            if (newFee !== currentFee) {
                const difference = newFee - currentFee;
                const differenceText = difference > 0
                    ? `+Rs. ${Math.abs(difference).toFixed(2)}`
                    : `-Rs. ${Math.abs(difference).toFixed(2)}`;

                const differenceClass = difference > 0 ? 'text-success' : 'text-danger';

                oldFeeAmount.textContent = `Rs. ${currentFee.toFixed(2)}`;
                newFeeAmount.textContent = `Rs. ${newFee.toFixed(2)}`;
                feeDifference.innerHTML = `<span class="${differenceClass}">${differenceText}</span>`;

                feeChangeSummary.classList.remove('d-none');
            } else {
                feeChangeSummary.classList.add('d-none');
            }
        }

        function updateCategoryFee() {
            const updateBtn = document.getElementById('updateCategoryFeeBtn');
            const originalText = updateBtn.innerHTML;

            const categoryClassId = document.getElementById('edit_category_class_id').value;
            const categoryId = document.getElementById('edit_category_id').value;
            const newFee = parseFloat(document.getElementById('edit_new_fee').value);
            const currentFee = parseFloat(document.getElementById('edit_current_fee').value);

            if (!newFee || newFee <= 0) {
                document.getElementById('edit_new_fee').classList.add('is-invalid');
                document.getElementById('edit_new_fee_error').textContent = 'Please enter a valid fee amount';
                return;
            }

            if (newFee === currentFee) {
                showAlert('Fee amount is the same as current fee. No changes made.', 'info');
                const modal = bootstrap.Modal.getInstance(document.getElementById('editCategoryFeeModal'));
                modal.hide();
                return;
            }

            updateBtn.disabled = true;
            updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

            fetch(`/api/class-has-category-classes/${categoryClassId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    fees: newFee,
                    class_category_id: categoryId,
                    student_classes_id: classId
                })
            })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw data;
                        }
                        return data;
                    });
                })
                .then(data => {
                    if (data.status === 'success') {
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editCategoryFeeModal'));
                        modal.hide();
                        loadAssignedCategories();
                        showAlert(`Category fee updated successfully from Rs. ${currentFee.toFixed(2)} to Rs. ${newFee.toFixed(2)}!`, 'success');
                    } else {
                        throw new Error(data.message || 'Failed to update category fee');
                    }
                })
                .catch(error => {
                    console.error('Error updating category fee:', error);

                    if (error.errors) {
                        const errorMessage = Object.values(error.errors).flat().join(', ');
                        showAlert('Error: ' + errorMessage, 'danger');
                    } else {
                        showAlert('Error updating category fee: ' + (error.message || 'Unknown error'), 'danger');
                    }
                })
                .finally(() => {
                    updateBtn.disabled = false;
                    updateBtn.innerHTML = originalText;
                });
        }

        function toggleCategoryStatus(id, currentStatus) {
            const actionText = currentStatus ? 'deactivate' : 'activate';

            if (!confirm(`Are you sure you want to ${actionText} this category?`)) return;

            fetch(`/api/class-has-category-classes/${id}/toggle-status`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw data;
                        }
                        return data;
                    });
                })
                .then(data => {
                    if (data.status === 'success') {
                        loadAssignedCategories();
                        showAlert(`Category ${currentStatus ? 'deactivated' : 'activated'} successfully!`, 'success');
                    } else {
                        throw new Error(data.message || `Failed to ${actionText}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error: ' + (error.message || `Failed to ${actionText} category`), 'danger');
                });
        }

        function escapeHtml(str) {
            if (str === null || str === undefined) return '';
            return String(str).replace(/[&<>"']/g, function (m) {
                switch (m) {
                    case '&': return '&amp;';
                    case '<': return '&lt;';
                    case '>': return '&gt;';
                    case '"': return '&quot;';
                    case "'": return '&#039;';
                    default: return m;
                }
            });
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.style.maxWidth = '420px';
            alertDiv.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <span>${escapeHtml(message)}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        `;
            document.body.appendChild(alertDiv);
            setTimeout(() => {
                if (alertDiv.parentNode) alertDiv.remove();
            }, 5000);
        }
    </script>
@endpush