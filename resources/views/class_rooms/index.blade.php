@extends('layouts.app')

@section('title', 'Manage Class Rooms')
@section('page-title', 'Class Rooms Management')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Class Rooms</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card bg-primary bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h4 class="card-title text-white">Total Classes</h4>
                                    <h2 class="text-white" id="totalClasses">0</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card bg-success bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h4 class="card-title text-white">Active Classes</h4>
                                    <h2 class="text-white" id="activeClasses">0</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-check-circle fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card bg-info bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h4 class="card-title text-white">Ongoing Classes</h4>
                                    <h2 class="text-white" id="ongoingClasses">0</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-play-circle fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card bg-warning bg-gradient">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h4 class="card-title text-white">Inactive Classes</h4>
                                    <h2 class="text-white" id="inactiveClasses">0</h2>
                                </div>
                                <div class="flex-shrink-0">
                                    <i class="fas fa-pause-circle fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Card -->
            <div class="card custom-card">
                <div class="card-header bg-transparent">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">Class Rooms Management</h5>
                            <p class="text-muted mb-0">Manage all class rooms and their information</p>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-primary" onclick="loadClassRooms()" title="Refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                            <a href="{{ route('class_rooms.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add New Class Room
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body position-relative">
                    <!-- Loading Spinner -->
                    <div id="loadingSpinner" class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading class rooms...</p>
                    </div>

                    <!-- Error Message -->
                    <div id="errorMessage" class="alert alert-danger d-none" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="errorText"></span>
                    </div>

                    <!-- Action Bar -->
                    <div class="d-none" id="actionBar">
                        <!-- Filters Row -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <!-- Status Filter -->
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary active" id="filterAll" data-status="">All</button>
                                        <button type="button" class="btn btn-outline-success" id="filterActive" data-status="active">Active</button>
                                        <button type="button" class="btn btn-outline-secondary" id="filterInactive" data-status="inactive">Inactive</button>
                                    </div>

                                    <!-- Ongoing Filter -->
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-outline-secondary active" id="filterOngoingAll" data-ongoing="">All</button>
                                        <button type="button" class="btn btn-outline-info" id="filterOngoing" data-ongoing="ongoing">Ongoing</button>
                                        <button type="button" class="btn btn-outline-secondary" id="filterNotOngoing" data-ongoing="not_ongoing">Not Ongoing</button>
                                    </div>

                                    <!-- Grade Filter -->
                                    <div class="d-flex align-items-center">
                                        <label for="gradeFilter" class="form-label text-muted mb-0 me-2">Grade:</label>
                                        <select class="form-select form-select-sm" id="gradeFilter" style="width: 120px;">
                                            <option value="">All Grades</option>
                                        </select>
                                    </div>

                                    <!-- Teacher Filter -->
                                    <div class="d-flex align-items-center">
                                        <label for="teacherFilter" class="form-label text-muted mb-0 me-2">Teacher:</label>
                                        <select class="form-select form-select-sm" id="teacherFilter" style="width: 140px;">
                                            <option value="">All Teachers</option>
                                        </select>
                                    </div>

                                    <!-- Subject Filter -->
                                    <div class="d-flex align-items-center">
                                        <label for="subjectFilter" class="form-label text-muted mb-0 me-2">Subject:</label>
                                        <select class="form-select form-select-sm" id="subjectFilter" style="width: 140px;">
                                            <option value="">All Subjects</option>
                                        </select>
                                    </div>

                                    <!-- Search Box -->
                                    <div class="input-group input-group-sm" style="width: 280px;">
                                        <span class="input-group-text bg-transparent">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search class rooms..." id="searchInput" autocomplete="off">
                                        <button class="btn btn-outline-secondary" type="button" id="clearSearchBtn" title="Clear">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Class Rooms Table -->
                    <div class="table-responsive" id="classRoomsTableContainer">
                        <table class="table table-hover" id="classRoomsTable">
                            <thead class="table-primary">
                                <tr>
                                    <th width="50" class="text-center">#</th>
                                    <th>Class Name</th>
                                    <th>Medium</th>
                                    <th>Teacher</th>
                                    <th>Subject</th>
                                    <th class="text-center">Grade</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Status</th>
                                    <th width="200" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="classRoomsTableBody">
                                <!-- Class rooms will be loaded here via JavaScript -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-3 d-none" id="paginationSection">
                        <div class="col-md-6">
                            <div class="text-muted" id="paginationInfo">
                                Showing <span id="startRecord">0</span> to <span id="endRecord">0</span> of <span id="totalRecords">0</span> entries
                            </div>
                        </div>
                        <div class="col-md-6">
                            <nav aria-label="Class rooms pagination">
                                <ul class="pagination justify-content-end mb-0" id="paginationLinks"></ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5 d-none">
                        <div class="empty-state-icon">
                            <i class="fas fa-chalkboard-teacher fa-4x text-muted mb-4"></i>
                        </div>
                        <h4 class="text-muted">No Class Rooms Found</h4>
                        <p class="text-muted mb-4">There are no class rooms in the database yet.</p>
                        <a href="{{ route('class_rooms.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus me-2"></i>Add First Class Room
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Activate Modal -->
    <div class="modal fade" id="activateClassRoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Activate Class Room</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to activate this class room?</p>
                    <div class="class-room-info bg-light p-3 rounded">
                        <strong id="activateClassName"></strong><br>
                        <small class="text-muted" id="activateClassTeacher"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="confirmActivateBtn">Activate Class</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Deactivate Modal -->
    <div class="modal fade" id="deactivateClassRoomModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title"><i class="fas fa-pause-circle me-2"></i>Deactivate Class Room</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to deactivate this class room?</p>
                    <div class="class-room-info bg-light p-3 rounded">
                        <strong id="deactivateClassName"></strong><br>
                        <small class="text-muted" id="deactivateClassTeacher"></small>
                    </div>
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        This class room will be marked as inactive.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-warning" id="confirmDeactivateBtn">Deactivate Class</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Ongoing Modal -->
    <div class="modal fade" id="startOngoingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title"><i class="fas fa-play-circle me-2"></i>Start Class Session</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to start this class session?</p>
                    <div class="class-room-info bg-light p-3 rounded">
                        <strong id="startClassName"></strong><br>
                        <small class="text-muted" id="startClassTeacher"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-info" id="confirmStartOngoingBtn">Start Session</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Stop Ongoing Modal -->
    <div class="modal fade" id="stopOngoingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title"><i class="fas fa-stop-circle me-2"></i>Stop Class Session</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to stop this class session?</p>
                    <div class="class-room-info bg-light p-3 rounded">
                        <strong id="stopClassName"></strong><br>
                        <small class="text-muted" id="stopClassTeacher"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-dark" id="confirmStopOngoingBtn">Stop Session</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .stat-card {
            border: none;
            border-radius: 15px;
            transition: transform 0.2s ease-in-out;
            cursor: pointer;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .custom-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            font-weight: 600;
            border: none;
            padding: 1rem 0.75rem;
            font-size: 0.85rem;
        }
        .table td {
            vertical-align: middle;
            padding: 0.75rem;
            border-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
        }
        .badge {
            font-size: 0.75rem;
            padding: 0.4em 0.7em;
            border-radius: 8px;
        }
        .btn-group .btn {
            border-radius: 6px;
            margin: 0 2px;
        }
        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
        }
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #007bff, #0056b3);
            border-color: #007bff;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Global variables
        let currentPage = 1;
        let totalPages = 1;
        let rowsPerPage = 15;
        let totalRecords = 0;
        let currentStatusFilter = '';
        let currentOngoingFilter = '';
        let currentGradeFilter = '';
        let currentTeacherFilter = '';
        let currentSubjectFilter = '';
        let currentSearch = '';

        document.addEventListener('DOMContentLoaded', function() {
            initializePage();
        });

        function initializePage() {
            loadFilters();
            loadClassRooms();
            attachEventListeners();
        }

        function attachEventListeners() {
            // Filters
            document.getElementById('gradeFilter')?.addEventListener('change', function() {
                currentGradeFilter = this.value;
                currentPage = 1;
                applyFilters();
            });
            document.getElementById('teacherFilter')?.addEventListener('change', function() {
                currentTeacherFilter = this.value;
                currentPage = 1;
                applyFilters();
            });
            document.getElementById('subjectFilter')?.addEventListener('change', function() {
                currentSubjectFilter = this.value;
                currentPage = 1;
                applyFilters();
            });
            document.getElementById('searchInput')?.addEventListener('input', debounce(function(e) {
                currentSearch = e.target.value;
                currentPage = 1;
                applyFilters();
            }, 300));
            document.getElementById('clearSearchBtn')?.addEventListener('click', function() {
                document.getElementById('searchInput').value = '';
                currentSearch = '';
                currentPage = 1;
                applyFilters();
            });

            // Status filters
            document.getElementById('filterAll')?.addEventListener('click', function() {
                setActiveStatusFilter(this, '');
            });
            document.getElementById('filterActive')?.addEventListener('click', function() {
                setActiveStatusFilter(this, 'active');
            });
            document.getElementById('filterInactive')?.addEventListener('click', function() {
                setActiveStatusFilter(this, 'inactive');
            });

            // Ongoing filters
            document.getElementById('filterOngoingAll')?.addEventListener('click', function() {
                setActiveOngoingFilter(this, '');
            });
            document.getElementById('filterOngoing')?.addEventListener('click', function() {
                setActiveOngoingFilter(this, 'ongoing');
            });
            document.getElementById('filterNotOngoing')?.addEventListener('click', function() {
                setActiveOngoingFilter(this, 'not_ongoing');
            });

            // Modal buttons
            document.getElementById('confirmActivateBtn')?.addEventListener('click', confirmActivate);
            document.getElementById('confirmDeactivateBtn')?.addEventListener('click', confirmDeactivate);
            document.getElementById('confirmStartOngoingBtn')?.addEventListener('click', confirmStartOngoing);
            document.getElementById('confirmStopOngoingBtn')?.addEventListener('click', confirmStopOngoing);
        }

        function setActiveStatusFilter(button, status) {
            document.querySelectorAll('[id^="filter"][id$="Active"],[id^="filterAll"]').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
            currentStatusFilter = status;
            currentPage = 1;
            applyFilters();
        }

        function setActiveOngoingFilter(button, ongoing) {
            document.querySelectorAll('[id^="filterOngoing"]').forEach(btn => {
                btn.classList.remove('active');
            });
            button.classList.add('active');
            currentOngoingFilter = ongoing;
            currentPage = 1;
            applyFilters();
        }

        function loadFilters() {
            // Load grades
            fetch("{{ url('/api/grades/dropdown') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const gradeFilter = document.getElementById('gradeFilter');
                        gradeFilter.innerHTML = '<option value="">All Grades</option>';
                        data.data.forEach(grade => {
                            gradeFilter.innerHTML += `<option value="${grade.id}">Grade ${grade.grade_name}</option>`;
                        });
                    }
                })
                .catch(err => console.error('Error loading grades:', err));

            // Load teachers
            fetch("{{ url('/api/teachers/dropdown') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const teacherFilter = document.getElementById('teacherFilter');
                        teacherFilter.innerHTML = '<option value="">All Teachers</option>';
                        data.data.forEach(teacher => {
                            teacherFilter.innerHTML += `<option value="${teacher.id}">${teacher.fname} ${teacher.lname}</option>`;
                        });
                    }
                })
                .catch(err => console.error('Error loading teachers:', err));

            // Load subjects
            fetch("{{ url('/api/subjects/dropdown') }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const subjectFilter = document.getElementById('subjectFilter');
                        subjectFilter.innerHTML = '<option value="">All Subjects</option>';
                        data.data.forEach(subject => {
                            subjectFilter.innerHTML += `<option value="${subject.id}">${subject.subject_name}</option>`;
                        });
                    }
                })
                .catch(err => console.error('Error loading subjects:', err));
        }

        function loadClassRooms() {
            showLoading();
            
            let url = `{{ url('/api/class-rooms/all') }}?page=${currentPage}&per_page=${rowsPerPage}`;
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const pagination = data.meta || {};
                        totalRecords = pagination.total || 0;
                        totalPages = pagination.last_page || 1;
                        currentPage = pagination.current_page || 1;
                        
                        renderTable(data.data || []);
                        updateStatistics(data.data || []);
                        updatePagination();
                        hideLoading();
                    } else {
                        throw new Error(data.message || 'Failed to load');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError(error.message);
                });
        }

        function applyFilters() {
            showLoading();
            
            let url = `{{ url('/api/class-rooms/all') }}?page=${currentPage}&per_page=${rowsPerPage}`;
            if (currentStatusFilter) url += `&status=${currentStatusFilter}`;
            if (currentOngoingFilter) url += `&ongoing=${currentOngoingFilter}`;
            if (currentGradeFilter) url += `&grade_id=${currentGradeFilter}`;
            if (currentTeacherFilter) url += `&teacher_id=${currentTeacherFilter}`;
            if (currentSubjectFilter) url += `&subject_id=${currentSubjectFilter}`;
            if (currentSearch) url += `&search=${encodeURIComponent(currentSearch)}`;
            
            fetch(url)
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        const pagination = data.meta || {};
                        totalRecords = pagination.total || 0;
                        totalPages = pagination.last_page || 1;
                        currentPage = pagination.current_page || 1;
                        
                        renderTable(data.data || []);
                        updateStatistics(data.data || []);
                        updatePagination();
                        hideLoading();
                    } else {
                        throw new Error(data.message || 'Failed to load');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError(error.message);
                });
        }

        function renderTable(classRooms) {
            const tbody = document.getElementById('classRoomsTableBody');
            const tableContainer = document.getElementById('classRoomsTableContainer');
            const emptyState = document.getElementById('emptyState');
            const paginationSection = document.getElementById('paginationSection');
            
            if (!classRooms.length) {
                tableContainer.classList.add('d-none');
                paginationSection.classList.add('d-none');
                emptyState.classList.remove('d-none');
                return;
            }
            
            tableContainer.classList.remove('d-none');
            paginationSection.classList.remove('d-none');
            emptyState.classList.add('d-none');
            
            tbody.innerHTML = '';
            const start = (currentPage - 1) * rowsPerPage;
            
            classRooms.forEach((cr, index) => {
                const row = `
                    <tr>
                        <td class="text-center fw-bold">${start + index + 1}</td>
                        <td><strong>${escapeHtml(cr.class_name)}</strong></td>
                        <td>${getMediumBadge(cr.medium)}</td>
                        <td>${cr.teacher ? escapeHtml(cr.teacher.fname + ' ' + cr.teacher.lname) : 'N/A'}</td>
                        <td>${cr.subject ? escapeHtml(cr.subject.subject_name) : 'N/A'}</td>
                        <td class="text-center">
                            <span class="badge bg-primary bg-gradient">
                                ${cr.grade ? 'Grade ' + cr.grade.grade_name : 'N/A'}
                            </span>
                        </td>
                        <td class="text-center">${getTypeBadge(cr.class_type)}</td>
                        <td class="text-center">
                            <div class="d-flex flex-column gap-1 align-items-center">
                                ${getStatusBadge(cr.is_active)}
                                ${getOngoingBadge(cr.is_ongoing)}
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-outline-primary" onclick="viewClass(${cr.id})" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-outline-warning" onclick="editClass(${cr.id})" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                ${getActivateButton(cr)}
                                ${getOngoingButton(cr)}
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });
        }

        function getMediumBadge(medium) {
            if (!medium) return '<span class="badge bg-secondary">N/A</span>';
            const badges = {
                sinhala: '<span class="badge bg-success">සිංහල</span>',
                english: '<span class="badge bg-info">English</span>',
                tamil: '<span class="badge bg-warning">தமிழ்</span>'
            };
            return badges[medium] || `<span class="badge bg-secondary">${medium}</span>`;
        }

        function getTypeBadge(type) {
            if (type === 'online') return '<span class="badge bg-info"><i class="fas fa-laptop me-1"></i>Online</span>';
            if (type === 'offline') return '<span class="badge bg-warning text-dark"><i class="fas fa-school me-1"></i>Offline</span>';
            return '<span class="badge bg-secondary">N/A</span>';
        }

        function getStatusBadge(isActive) {
            if (isActive) {
                return '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Active</span>';
            }
            return '<span class="badge bg-secondary"><i class="fas fa-pause-circle me-1"></i>Inactive</span>';
        }

        function getOngoingBadge(isOngoing) {
            if (isOngoing) {
                return '<span class="badge bg-info"><i class="fas fa-play-circle me-1"></i>Ongoing</span>';
            }
            return '<span class="badge bg-light text-dark border"><i class="fas fa-stop-circle me-1"></i>Not Ongoing</span>';
        }

        function getActivateButton(cr) {
            if (cr.is_active) {
                if (cr.is_ongoing) {
                    return `<button class="btn btn-outline-warning" title="Cannot deactivate ongoing class" disabled>
                                <i class="fas fa-pause-circle"></i>
                            </button>`;
                }
                return `<button class="btn btn-outline-warning" title="Deactivate" 
                                onclick="showDeactivateModal(${cr.id}, '${escapeHtml(cr.class_name)}', '${escapeHtml(cr.teacher?.fname + ' ' + cr.teacher?.lname)}')">
                            <i class="fas fa-pause-circle"></i>
                        </button>`;
            }
            return `<button class="btn btn-outline-success" title="Activate" 
                            onclick="showActivateModal(${cr.id}, '${escapeHtml(cr.class_name)}', '${escapeHtml(cr.teacher?.fname + ' ' + cr.teacher?.lname)}')">
                        <i class="fas fa-check-circle"></i>
                    </button>`;
        }

        function getOngoingButton(cr) {
            if (cr.is_ongoing) {
                return `<button class="btn btn-outline-dark" title="Stop Ongoing" 
                                onclick="showStopModal(${cr.id}, '${escapeHtml(cr.class_name)}', '${escapeHtml(cr.teacher?.fname + ' ' + cr.teacher?.lname)}')">
                            <i class="fas fa-stop-circle"></i>
                        </button>`;
            }
            if (cr.is_active) {
                return `<button class="btn btn-outline-info" title="Start Ongoing" 
                                onclick="showStartModal(${cr.id}, '${escapeHtml(cr.class_name)}', '${escapeHtml(cr.teacher?.fname + ' ' + cr.teacher?.lname)}')">
                            <i class="fas fa-play-circle"></i>
                        </button>`;
            }
            return `<button class="btn btn-outline-info" title="Cannot start ongoing for inactive class" disabled>
                        <i class="fas fa-play-circle"></i>
                    </button>`;
        }

        function updateStatistics(classRooms) {
            document.getElementById('totalClasses').textContent = totalRecords;
            document.getElementById('activeClasses').textContent = classRooms.filter(c => c.is_active).length;
            document.getElementById('ongoingClasses').textContent = classRooms.filter(c => c.is_ongoing).length;
            document.getElementById('inactiveClasses').textContent = classRooms.filter(c => !c.is_active).length;
        }

        function updatePagination() {
            const start = totalRecords > 0 ? (currentPage - 1) * rowsPerPage + 1 : 0;
            const end = Math.min(currentPage * rowsPerPage, totalRecords);
            
            document.getElementById('startRecord').textContent = start;
            document.getElementById('endRecord').textContent = end;
            document.getElementById('totalRecords').textContent = totalRecords;
            
            const paginationLinks = document.getElementById('paginationLinks');
            paginationLinks.innerHTML = '';
            
            // Previous
            paginationLinks.innerHTML += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage - 1})">Previous</a>
            </li>`;
            
            // Page numbers
            let startPage = Math.max(1, currentPage - 2);
            let endPage = Math.min(totalPages, startPage + 4);
            if (endPage - startPage < 4) startPage = Math.max(1, endPage - 4);
            
            for (let i = startPage; i <= endPage; i++) {
                paginationLinks.innerHTML += `<li class="page-item ${currentPage === i ? 'active' : ''}">
                    <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
                </li>`;
            }
            
            // Next
            paginationLinks.innerHTML += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                <a class="page-link" href="#" onclick="changePage(${currentPage + 1})">Next</a>
            </li>`;
        }

        function changePage(page) {
            if (page < 1 || page > totalPages) return;
            currentPage = page;
            if (currentStatusFilter || currentOngoingFilter || currentGradeFilter || currentTeacherFilter || currentSubjectFilter || currentSearch) {
                applyFilters();
            } else {
                loadClassRooms();
            }
        }

        // Modal functions
        let currentClassId = null;
        
        function showActivateModal(id, name, teacher) {
            currentClassId = id;
            document.getElementById('activateClassName').textContent = name;
            document.getElementById('activateClassTeacher').textContent = `Teacher: ${teacher}`;
            new bootstrap.Modal(document.getElementById('activateClassRoomModal')).show();
        }
        
        function showDeactivateModal(id, name, teacher) {
            currentClassId = id;
            document.getElementById('deactivateClassName').textContent = name;
            document.getElementById('deactivateClassTeacher').textContent = `Teacher: ${teacher}`;
            new bootstrap.Modal(document.getElementById('deactivateClassRoomModal')).show();
        }
        
        function showStartModal(id, name, teacher) {
            currentClassId = id;
            document.getElementById('startClassName').textContent = name;
            document.getElementById('startClassTeacher').textContent = `Teacher: ${teacher}`;
            new bootstrap.Modal(document.getElementById('startOngoingModal')).show();
        }
        
        function showStopModal(id, name, teacher) {
            currentClassId = id;
            document.getElementById('stopClassName').textContent = name;
            document.getElementById('stopClassTeacher').textContent = `Teacher: ${teacher}`;
            new bootstrap.Modal(document.getElementById('stopOngoingModal')).show();
        }
        
        function confirmActivate() {
            if (!currentClassId) return;
            fetch(`/api/class-rooms/${currentClassId}/reactivate-active`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('activateClassRoomModal')).hide();
                    showAlert('Class activated successfully!', 'success');
                    applyFilters();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(err => showAlert('Error: ' + err.message, 'danger'));
        }
        
        function confirmDeactivate() {
            if (!currentClassId) return;
            fetch(`/api/class-rooms/${currentClassId}/deactivate-active`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('deactivateClassRoomModal')).hide();
                    showAlert('Class deactivated successfully!', 'success');
                    applyFilters();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(err => showAlert('Error: ' + err.message, 'danger'));
        }
        
        function confirmStartOngoing() {
            if (!currentClassId) return;
            fetch(`/api/class-rooms/${currentClassId}/reactivate-ongoing`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('startOngoingModal')).hide();
                    showAlert('Class session started!', 'success');
                    applyFilters();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(err => showAlert('Error: ' + err.message, 'danger'));
        }
        
        function confirmStopOngoing() {
            if (!currentClassId) return;
            fetch(`/api/class-rooms/${currentClassId}/deactivate-ongoing`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('stopOngoingModal')).hide();
                    showAlert('Class session stopped!', 'success');
                    applyFilters();
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(err => showAlert('Error: ' + err.message, 'danger'));
        }
        
        function viewClass(id) { window.location.href = `/class-rooms/${id}`; }
        function editClass(id) { window.location.href = `/class-rooms/${id}/edit`; }
        
        function showLoading() {
            document.getElementById('loadingSpinner').classList.remove('d-none');
            document.getElementById('actionBar').classList.add('d-none');
        }
        
        function hideLoading() {
            document.getElementById('loadingSpinner').classList.add('d-none');
            document.getElementById('actionBar').classList.remove('d-none');
        }
        
        function showError(message) {
            document.getElementById('errorText').textContent = message;
            document.getElementById('errorMessage').classList.remove('d-none');
            setTimeout(() => {
                document.getElementById('errorMessage').classList.add('d-none');
            }, 5000);
        }
        
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `${message}<button type="button" class="btn-close" data-bs-dismiss="alert"></button>`;
            document.body.appendChild(alertDiv);
            setTimeout(() => alertDiv.remove(), 5000);
        }
        
        function debounce(func, wait) {
            let timeout;
            return function() {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, arguments), wait);
            };
        }
        
        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }
    </script>
@endpush