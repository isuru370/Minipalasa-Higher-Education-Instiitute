@extends('layouts.app')

@section('title', 'Create Class Room')
@section('page-title', 'Create New Class Room')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('class_rooms.index') }}">Class Rooms</a></li>
    <li class="breadcrumb-item active">Class Room Create</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Create Class Room Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Class Room Information</h5>
                </div>
                <div class="card-body">
                    <form id="createClassRoomForm">
                        @csrf
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Class Name -->
                                <div class="mb-3">
                                    <label for="class_name" class="form-label">Class Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="class_name" name="class_name" required>
                                    <div class="invalid-feedback" id="class_name_error"></div>
                                </div>

                                <!-- Teacher Dropdown -->
                                <div class="mb-3">
                                    <label for="teacher_id" class="form-label">Teacher <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="teacher_id" name="teacher_id" required>
                                        <option value="">Select Teacher</option>
                                    </select>
                                    <div class="invalid-feedback" id="teacher_id_error"></div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Class Type -->
                                <div class="mb-3">
                                    <label for="class_type" class="form-label">
                                        Class Type <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="class_type" name="class_type" required>
                                        <option value="">Select Class Type</option>
                                        <option value="offline">Offline</option>
                                        <option value="online">Online</option>
                                    </select>
                                    <div class="invalid-feedback" id="class_type_error"></div>
                                </div>

                                <!-- Medium Dropdown -->
                                <div class="mb-3">
                                    <label for="medium" class="form-label">
                                        <i class="fas fa-language me-2"></i>Medium <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select" id="medium" name="medium" required>
                                        <option value="">Select Medium</option>
                                        <option value="sinhala">සිංහල (Sinhala)</option>
                                        <option value="english">English</option>
                                        <option value="tamil">தமிழ் (Tamil)</option>
                                    </select>
                                    <div class="invalid-feedback" id="medium_error"></div>
                                </div>

                                <!-- Grade Dropdown with Add Button -->
                                <div class="mb-3">
                                    <label for="grade_id" class="form-label">Grade <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" id="grade_id" name="grade_id" required>
                                            <option value="">Select Grade</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addGradeModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="grade_id_error"></div>
                                </div>

                                <!-- Subject Dropdown with Add Button -->
                                <div class="mb-3">
                                    <label for="subject_id" class="form-label">Subject <span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <select class="form-select" id="subject_id" name="subject_id" required>
                                            <option value="">Select Subject</option>
                                        </select>
                                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#addSubjectModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" id="subject_id_error"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('class_rooms.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submitBtn">
                                        <i class="fas fa-save me-2"></i>Create Class Room
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Grades Table Card -->
            <div class="card mb-4">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Grades Management</h5>
                            <p class="text-muted mb-0">Manage all grades</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" onclick="loadGradesTable()" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search grades..." id="gradeSearch">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Grade Name</th>
                                    <th>Created At</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="gradesTableBody">
                            </tbody>
                        </table>
                    </div>

                    <div id="gradesLoading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading grades...</p>
                    </div>

                    <div id="gradesEmpty" class="text-center py-5 d-none">
                        <div class="empty-state-icon">
                            <i class="fas fa-graduation-cap fa-4x text-muted mb-4"></i>
                        </div>
                        <h4 class="text-muted">No Grades Found</h4>
                        <p class="text-muted mb-4">There are no grades in the database yet.</p>
                    </div>
                </div>
            </div>

            <!-- Subjects Table Card -->
            <div class="card">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Subjects Management</h5>
                            <p class="text-muted mb-0">Manage all subjects</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" onclick="loadSubjectsTable()" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-transparent">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Search subjects..." id="subjectSearch">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th width="60">#</th>
                                    <th>Subject Name</th>
                                    <th>Created At</th>
                                    <th width="120" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="subjectsTableBody">
                            </tbody>
                        </table>
                    </div>

                    <div id="subjectsLoading" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading subjects...</p>
                    </div>

                    <div id="subjectsEmpty" class="text-center py-5 d-none">
                        <div class="empty-state-icon">
                            <i class="fas fa-book fa-4x text-muted mb-4"></i>
                        </div>
                        <h4 class="text-muted">No Subjects Found</h4>
                        <p class="text-muted mb-4">There are no subjects in the database yet.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addGradeModalLabel">
                        <i class="fas fa-plus me-2"></i>Add New Grade
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="grade_name" class="form-label">Grade Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="grade_name" name="grade_name" required>
                        <div class="invalid-feedback" id="grade_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="saveGradeBtn">
                        <i class="fas fa-save me-2"></i>Save Grade
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Grade Modal -->
    <div class="modal fade" id="editGradeModal" tabindex="-1" aria-labelledby="editGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editGradeModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Grade
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_grade_id">
                    <div class="mb-3">
                        <label for="edit_grade_name" class="form-label">Grade Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_grade_name" name="grade_name" required>
                        <div class="invalid-feedback" id="edit_grade_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-warning" id="updateGradeBtn">
                        <i class="fas fa-save me-2"></i>Update Grade
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Subject Modal -->
    <div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addSubjectModalLabel">
                        <i class="fas fa-plus me-2"></i>Add New Subject
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="subject_name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="subject_name" name="subject_name" required>
                        <div class="invalid-feedback" id="subject_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="saveSubjectBtn">
                        <i class="fas fa-save me-2"></i>Save Subject
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="editSubjectModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Subject
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_subject_id">
                    <div class="mb-3">
                        <label for="edit_subject_name" class="form-label">Subject Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_subject_name" name="subject_name" required>
                        <div class="invalid-feedback" id="edit_subject_name_error"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-warning" id="updateSubjectBtn">
                        <i class="fas fa-save me-2"></i>Update Subject
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

        .card-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
            padding: 1.5rem;
        }

        .card-header.bg-transparent {
            background: transparent !important;
            color: inherit;
            border-bottom: 1px solid #dee2e6;
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border: none;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 123, 255, 0.3);
        }

        .table th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            font-weight: 600;
            border: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        let allGrades = [];
        let allSubjects = [];

        document.addEventListener('DOMContentLoaded', function() {
            loadTeachers();
            loadGrades();
            loadSubjects();
            loadGradesTable();
            loadSubjectsTable();

            const createClassRoomForm = document.getElementById('createClassRoomForm');
            createClassRoomForm.addEventListener('submit', function(e) {
                e.preventDefault();
                submitForm();
            });

            // Grade modal buttons
            const saveGradeBtn = document.getElementById('saveGradeBtn');
            if (saveGradeBtn) {
                saveGradeBtn.addEventListener('click', saveGrade);
            }

            const updateGradeBtn = document.getElementById('updateGradeBtn');
            if (updateGradeBtn) {
                updateGradeBtn.addEventListener('click', updateGrade);
            }

            // Subject modal buttons
            const saveSubjectBtn = document.getElementById('saveSubjectBtn');
            if (saveSubjectBtn) {
                saveSubjectBtn.addEventListener('click', saveSubject);
            }

            const updateSubjectBtn = document.getElementById('updateSubjectBtn');
            if (updateSubjectBtn) {
                updateSubjectBtn.addEventListener('click', updateSubject);
            }

            // Search functionality
            const gradeSearch = document.getElementById('gradeSearch');
            if (gradeSearch) {
                gradeSearch.addEventListener('input', debounce(filterGradesTable, 300));
            }

            const subjectSearch = document.getElementById('subjectSearch');
            if (subjectSearch) {
                subjectSearch.addEventListener('input', debounce(filterSubjectsTable, 300));
            }
        });

        function loadTeachers() {
            fetch("{{ url('/api/teachers/dropdown') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const teacherSelect = document.getElementById('teacher_id');
                        teacherSelect.innerHTML = '<option value="">Select Teacher</option>';
                        data.data.forEach(teacher => {
                            const option = document.createElement('option');
                            option.value = teacher.id;
                            option.textContent = `${teacher.fname} ${teacher.lname}`;
                            teacherSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => console.error('Error loading teachers:', error));
        }

        function loadGrades() {
            fetch("{{ url('/api/grades/dropdown') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const gradeSelect = document.getElementById('grade_id');
                        const currentValue = gradeSelect.value;
                        gradeSelect.innerHTML = '<option value="">Select Grade</option>';
                        data.data.forEach(grade => {
                            const option = document.createElement('option');
                            option.value = grade.id;
                            option.textContent = `Grade ${grade.grade_name}`;
                            gradeSelect.appendChild(option);
                        });
                        if (currentValue) gradeSelect.value = currentValue;
                    }
                })
                .catch(error => console.error('Error loading grades:', error));
        }

        function loadSubjects() {
            fetch("{{ url('/api/subjects/dropdown') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const subjectSelect = document.getElementById('subject_id');
                        const currentValue = subjectSelect.value;
                        subjectSelect.innerHTML = '<option value="">Select Subject</option>';
                        data.data.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.subject_name;
                            subjectSelect.appendChild(option);
                        });
                        if (currentValue) subjectSelect.value = currentValue;
                    }
                })
                .catch(error => console.error('Error loading subjects:', error));
        }

        function loadGradesTable() {
            showGradesLoading();
            fetch("{{ url('/api/grades') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        allGrades = data.data;
                    } else if (Array.isArray(data)) {
                        allGrades = data;
                    } else {
                        allGrades = [];
                    }
                    renderGradesTable(allGrades);
                    hideGradesLoading();
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideGradesLoading();
                });
        }

        function renderGradesTable(grades) {
            const tbody = document.getElementById('gradesTableBody');
            const emptyState = document.getElementById('gradesEmpty');
            
            if (!tbody) return;
            tbody.innerHTML = '';

            if (grades.length === 0) {
                if (emptyState) emptyState.classList.remove('d-none');
                return;
            }

            if (emptyState) emptyState.classList.add('d-none');

            grades.forEach((grade, index) => {
                const row = `
                    <tr>
                        <td class="fw-bold text-muted">${index + 1}</td>
                        <td>Grade ${grade.grade_name}</td>
                        <td>${new Date(grade.created_at).toLocaleDateString()}</td>
                        <td class="text-center">
                            <button class="btn btn-outline-warning btn-sm" onclick="showEditGradeModal(${grade.id}, '${escapeHtml(grade.grade_name)}')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function filterGradesTable() {
            const searchTerm = document.getElementById('gradeSearch').value.toLowerCase();
            const filtered = allGrades.filter(grade => grade.grade_name.toLowerCase().includes(searchTerm));
            renderGradesTable(filtered);
        }

        function showGradesLoading() {
            const loading = document.getElementById('gradesLoading');
            const table = document.querySelector('#gradesTableBody')?.closest('.table-responsive');
            if (loading) loading.classList.remove('d-none');
            if (table) table.classList.add('d-none');
        }

        function hideGradesLoading() {
            const loading = document.getElementById('gradesLoading');
            const table = document.querySelector('#gradesTableBody')?.closest('.table-responsive');
            if (loading) loading.classList.add('d-none');
            if (table) table.classList.remove('d-none');
        }

        function loadSubjectsTable() {
            showSubjectsLoading();
            fetch("{{ url('/api/subjects') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        allSubjects = data.data;
                    } else if (Array.isArray(data)) {
                        allSubjects = data;
                    } else {
                        allSubjects = [];
                    }
                    renderSubjectsTable(allSubjects);
                    hideSubjectsLoading();
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideSubjectsLoading();
                });
        }

        function renderSubjectsTable(subjects) {
            const tbody = document.getElementById('subjectsTableBody');
            const emptyState = document.getElementById('subjectsEmpty');
            
            if (!tbody) return;
            tbody.innerHTML = '';

            if (subjects.length === 0) {
                if (emptyState) emptyState.classList.remove('d-none');
                return;
            }

            if (emptyState) emptyState.classList.add('d-none');

            subjects.forEach((subject, index) => {
                const row = `
                    <tr>
                        <td class="fw-bold text-muted">${index + 1}</td>
                        <td>${subject.subject_name}</td>
                        <td>${new Date(subject.created_at).toLocaleDateString()}</td>
                        <td class="text-center">
                            <button class="btn btn-outline-warning btn-sm" onclick="showEditSubjectModal(${subject.id}, '${escapeHtml(subject.subject_name)}')">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function filterSubjectsTable() {
            const searchTerm = document.getElementById('subjectSearch').value.toLowerCase();
            const filtered = allSubjects.filter(subject => subject.subject_name.toLowerCase().includes(searchTerm));
            renderSubjectsTable(filtered);
        }

        function showSubjectsLoading() {
            const loading = document.getElementById('subjectsLoading');
            const table = document.querySelector('#subjectsTableBody')?.closest('.table-responsive');
            if (loading) loading.classList.remove('d-none');
            if (table) table.classList.add('d-none');
        }

        function hideSubjectsLoading() {
            const loading = document.getElementById('subjectsLoading');
            const table = document.querySelector('#subjectsTableBody')?.closest('.table-responsive');
            if (loading) loading.classList.add('d-none');
            if (table) table.classList.remove('d-none');
        }

        function showEditGradeModal(id, name) {
            document.getElementById('edit_grade_id').value = id;
            document.getElementById('edit_grade_name').value = name;
            new bootstrap.Modal(document.getElementById('editGradeModal')).show();
        }

        function showEditSubjectModal(id, name) {
            document.getElementById('edit_subject_id').value = id;
            document.getElementById('edit_subject_name').value = name;
            new bootstrap.Modal(document.getElementById('editSubjectModal')).show();
        }

        function saveGrade() {
            const gradeName = document.getElementById('grade_name').value.trim();
            if (!gradeName) {
                showAlert('Please enter grade name', 'warning');
                return;
            }

            const btn = document.getElementById('saveGradeBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

            fetch("{{ url('/api/grades') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ grade_name: gradeName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('addGradeModal')).hide();
                    document.getElementById('grade_name').value = '';
                    loadGrades();
                    loadGradesTable();
                    showAlert('Grade created successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to create grade');
                }
            })
            .catch(error => {
                showAlert('Error: ' + error.message, 'danger');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        function updateGrade() {
            const id = document.getElementById('edit_grade_id').value;
            const name = document.getElementById('edit_grade_name').value.trim();
            
            if (!name) {
                showAlert('Please enter grade name', 'warning');
                return;
            }

            const btn = document.getElementById('updateGradeBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

            fetch(`/api/grades/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ grade_name: name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('editGradeModal')).hide();
                    loadGrades();
                    loadGradesTable();
                    showAlert('Grade updated successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to update grade');
                }
            })
            .catch(error => {
                showAlert('Error: ' + error.message, 'danger');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        function saveSubject() {
            const subjectName = document.getElementById('subject_name').value.trim();
            if (!subjectName) {
                showAlert('Please enter subject name', 'warning');
                return;
            }

            const btn = document.getElementById('saveSubjectBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';

            fetch("{{ url('/api/subjects') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ subject_name: subjectName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('addSubjectModal')).hide();
                    document.getElementById('subject_name').value = '';
                    loadSubjects();
                    loadSubjectsTable();
                    showAlert('Subject created successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to create subject');
                }
            })
            .catch(error => {
                showAlert('Error: ' + error.message, 'danger');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        function updateSubject() {
            const id = document.getElementById('edit_subject_id').value;
            const name = document.getElementById('edit_subject_name').value.trim();
            
            if (!name) {
                showAlert('Please enter subject name', 'warning');
                return;
            }

            const btn = document.getElementById('updateSubjectBtn');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

            fetch(`/api/subjects/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ subject_name: name })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('editSubjectModal')).hide();
                    loadSubjects();
                    loadSubjectsTable();
                    showAlert('Subject updated successfully!', 'success');
                } else {
                    throw new Error(data.message || 'Failed to update subject');
                }
            })
            .catch(error => {
                showAlert('Error: ' + error.message, 'danger');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalText;
            });
        }

        function submitForm() {
            const submitBtn = document.getElementById('submitBtn');
            const originalText = submitBtn.innerHTML;

            const medium = document.getElementById('medium').value;
            if (!medium) {
                showAlert('Please select a medium', 'warning');
                document.getElementById('medium').classList.add('is-invalid');
                return;
            }

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating...';

            const data = {
                class_name: document.getElementById('class_name').value,
                class_type: document.getElementById('class_type').value,
                medium: document.getElementById('medium').value,
                teacher_id: document.getElementById('teacher_id').value,
                subject_id: document.getElementById('subject_id').value,
                grade_id: document.getElementById('grade_id').value,
                is_active: 1,
                is_ongoing: 0
            };

            fetch("{{ url('/api/class-rooms') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    showAlert('Class room created successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = "{{ route('class_rooms.index') }}";
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to create class room');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Error: ' + (error.message || 'Something went wrong'), 'danger');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            });
        }

        function debounce(func, wait) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, arguments), wait);
            };
        }

        function escapeHtml(unsafe) {
            if (!unsafe) return '';
            return String(unsafe).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }

        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 5000);
        }
    </script>
@endpush