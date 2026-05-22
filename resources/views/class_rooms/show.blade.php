@extends('layouts.app')

@section('title', 'Class Details')
@section('page-title', 'Class Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('class_rooms.index') }}">Class Rooms</a></li>
    <li class="breadcrumb-item active">Class Details</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Class Details
                        </h5>
                        <div>
                            <a href="{{ route('class_rooms.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Back
                            </a>
                            <a href="{{ route('class_rooms.edit', $id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Loading State -->
                    <div id="loadingState" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Loading class details...</p>
                    </div>

                    <!-- Error State -->
                    <div id="errorState" class="alert alert-danger d-none">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <span id="errorMessage"></span>
                    </div>

                    <!-- Class Details Content -->
                    <div id="classDetailsContent" class="d-none">
                        <!-- Basic Info Row -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h3 id="className" class="fw-bold mb-2">-</h3>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span id="classCode" class="badge bg-secondary">#ID</span>
                                    <span id="classTypeBadge" class="badge bg-info">Type</span>
                                    <span id="mediumBadge" class="badge bg-success">Medium</span>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="text-muted small">
                                    <div><i class="fas fa-calendar-alt me-1"></i> Created: <span id="createdDate">-</span></div>
                                    <div><i class="fas fa-edit me-1"></i> Updated: <span id="updatedDate">-</span></div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Cards Row -->
                        <div class="row">
                            <!-- Teacher Card -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-user-tie me-1 text-primary"></i> Teacher Information
                                        </h6>
                                        <h5 class="card-title mb-2" id="teacherName">-</h5>
                                        <p class="card-text mb-1">
                                            <small class="text-muted">ID:</small> <span id="teacherId">-</span>
                                        </p>
                                        <p class="card-text">
                                            <small class="text-muted">Email:</small> <span id="teacherEmail">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Subject Card -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-book me-1 text-success"></i> Subject Information
                                        </h6>
                                        <h5 class="card-title mb-2" id="subjectName">-</h5>
                                        <p class="card-text">
                                            <small class="text-muted">ID:</small> <span id="subjectId">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Grade Card -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-graduation-cap me-1 text-warning"></i> Grade Information
                                        </h6>
                                        <h5 class="card-title mb-2" id="gradeName">-</h5>
                                        <p class="card-text">
                                            <small class="text-muted">ID:</small> <span id="gradeId">-</span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Class Type Card -->
                            <div class="col-md-6 mb-3">
                                <div class="card h-100 border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <i class="fas fa-info-circle me-1 text-info"></i> Class Details
                                        </h6>
                                        <div class="mb-2">
                                            <strong>Type:</strong> <span id="classTypeDetail">-</span>
                                        </div>
                                        <div>
                                            <strong>Medium:</strong> <span id="mediumDetail">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status Row -->
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card border">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-3 text-muted">
                                            <i class="fas fa-chart-line me-1"></i> Status
                                        </h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded mb-2">
                                                    <span>Active Status</span>
                                                    <span id="activeStatus" class="badge">-</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                    <span>Ongoing Status</span>
                                                    <span id="ongoingStatus" class="badge">-</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
        }
        .card-header {
            background: #f8f9fa;
            border-bottom: 2px solid #e9ecef;
            padding: 1rem 1.25rem;
        }
        .badge {
            padding: 0.4rem 0.8rem;
            font-weight: 500;
        }
        .bg-light {
            background-color: #f8f9fa !important;
        }
        .border {
            border: 1px solid #e9ecef !important;
        }
        .table-info-row {
            display: flex;
            justify-content: space-between;
            padding: 0.5rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .table-info-row:last-child {
            border-bottom: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const classId = {{ $id }};

        document.addEventListener('DOMContentLoaded', function() {
            loadClassDetails();
        });

        function loadClassDetails() {
            showLoadingState();

            fetch(`/api/class-rooms/${classId}`)
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP ${response.status}`);
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success' && data.data) {
                        renderClassDetails(data.data);
                        showContentState();
                    } else {
                        throw new Error(data.message || 'Invalid response');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showErrorState(error.message);
                });
        }

        function renderClassDetails(classData) {
            // Class Type
            const classType = classData.class_type?.toLowerCase() || 'default';
            const typeConfig = {
                online: { text: 'Online', badgeClass: 'bg-info' },
                offline: { text: 'Offline', badgeClass: 'bg-warning' }
            };
            const type = typeConfig[classType] || { text: classData.class_type || 'N/A', badgeClass: 'bg-secondary' };

            // Medium
            const mediumConfig = {
                sinhala: { text: 'සිංහල', badgeClass: 'bg-success' },
                english: { text: 'English', badgeClass: 'bg-primary' },
                tamil: { text: 'தமிழ்', badgeClass: 'bg-danger' }
            };
            const medium = mediumConfig[classData.medium] || { text: classData.medium || 'N/A', badgeClass: 'bg-secondary' };

            // Basic Info
            document.getElementById('className').textContent = classData.class_name || 'Unnamed Class';
            document.getElementById('classCode').innerHTML = `<i class="fas fa-hashtag me-1"></i>#${classData.id}`;
            
            const classTypeBadge = document.getElementById('classTypeBadge');
            classTypeBadge.className = `badge ${type.badgeClass}`;
            classTypeBadge.innerHTML = `<i class="fas ${classType === 'online' ? 'fa-globe' : 'fa-building'} me-1"></i>${type.text}`;
            
            const mediumBadge = document.getElementById('mediumBadge');
            mediumBadge.className = `badge ${medium.badgeClass}`;
            mediumBadge.innerHTML = `<i class="fas fa-language me-1"></i>${medium.text}`;

            // Dates
            document.getElementById('createdDate').textContent = formatDate(classData.created_at);
            document.getElementById('updatedDate').textContent = formatDate(classData.updated_at);

            // Teacher Info
            if (classData.teacher) {
                document.getElementById('teacherName').textContent = `${classData.teacher.fname} ${classData.teacher.lname}`;
                document.getElementById('teacherId').textContent = classData.teacher.custom_id || `#${classData.teacher.id}`;
                document.getElementById('teacherEmail').textContent = classData.teacher.email || 'No email';
            } else {
                document.getElementById('teacherName').textContent = 'Not Assigned';
                document.getElementById('teacherId').textContent = '-';
                document.getElementById('teacherEmail').textContent = '-';
            }

            // Subject Info
            if (classData.subject) {
                document.getElementById('subjectName').textContent = classData.subject.subject_name;
                document.getElementById('subjectId').textContent = `#${classData.subject.id}`;
            } else {
                document.getElementById('subjectName').textContent = 'Not Assigned';
                document.getElementById('subjectId').textContent = '-';
            }

            // Grade Info
            if (classData.grade) {
                document.getElementById('gradeName').textContent = `Grade ${classData.grade.grade_name}`;
                document.getElementById('gradeId').textContent = `#${classData.grade.id}`;
            } else {
                document.getElementById('gradeName').textContent = 'Not Assigned';
                document.getElementById('gradeId').textContent = '-';
            }

            // Class Details
            document.getElementById('classTypeDetail').innerHTML = `<span class="badge ${type.badgeClass}">${type.text}</span>`;
            document.getElementById('mediumDetail').innerHTML = `<span class="badge ${medium.badgeClass}">${medium.text}</span>`;

            // Status
            const activeStatus = document.getElementById('activeStatus');
            const isActive = classData.is_active == 1;
            activeStatus.className = `badge ${isActive ? 'bg-success' : 'bg-secondary'}`;
            activeStatus.innerHTML = isActive ? '<i class="fas fa-check-circle me-1"></i>Active' : '<i class="fas fa-times-circle me-1"></i>Inactive';

            const ongoingStatus = document.getElementById('ongoingStatus');
            const isOngoing = classData.is_ongoing == 1;
            ongoingStatus.className = `badge ${isOngoing ? 'bg-info' : 'bg-secondary'}`;
            ongoingStatus.innerHTML = isOngoing ? '<i class="fas fa-play-circle me-1"></i>Ongoing' : '<i class="fas fa-stop-circle me-1"></i>Not Ongoing';
        }

        function formatDate(dateString) {
            if (!dateString) return '-';
            try {
                const date = new Date(dateString);
                if (isNaN(date.getTime())) return dateString;
                return date.toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });
            } catch {
                return dateString;
            }
        }

        function showLoadingState() {
            document.getElementById('loadingState').classList.remove('d-none');
            document.getElementById('errorState').classList.add('d-none');
            document.getElementById('classDetailsContent').classList.add('d-none');
        }

        function showContentState() {
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('errorState').classList.add('d-none');
            document.getElementById('classDetailsContent').classList.remove('d-none');
        }

        function showErrorState(message) {
            document.getElementById('loadingState').classList.add('d-none');
            document.getElementById('errorState').classList.remove('d-none');
            document.getElementById('classDetailsContent').classList.add('d-none');
            document.getElementById('errorMessage').textContent = message;
        }
    </script>
@endpush