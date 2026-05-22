@extends('layouts.app')

@section('title', 'Edit Class Room')
@section('page-title', 'Edit Class Room')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('class_rooms.index') }}">Class Rooms</a></li>
    <li class="breadcrumb-item"><a href="{{ route('class_rooms.show', $id) }}">Class Details</a></li>
    <li class="breadcrumb-item active">Edit Class Room</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-edit me-2"></i>Edit Class Room
                            </h5>
                            <button class="btn btn-light btn-sm" onclick="loadAllData()" title="Refresh" type="button">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <form id="editClassRoomForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="class_name" class="form-label">
                                            Class Name <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" id="class_name" name="class_name" required>
                                        <div class="invalid-feedback" id="class_name_error"></div>
                                    </div>

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

                                    <div class="mb-3">
                                        <label for="medium" class="form-label">
                                            Medium <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="medium" name="medium" required>
                                            <option value="">Select Medium</option>
                                            <option value="Sinhala">සිංහල (Sinhala)</option>
                                            <option value="English">English</option>
                                            <option value="Tamil">தமிழ் (Tamil)</option>
                                        </select>
                                        <div class="invalid-feedback" id="medium_error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="teacher_id" class="form-label">
                                            Teacher <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="teacher_id" name="teacher_id" required>
                                            <option value="">Select Teacher</option>
                                        </select>
                                        <div class="invalid-feedback" id="teacher_id_error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="grade_id" class="form-label">
                                            Grade <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="grade_id" name="grade_id" required>
                                            <option value="">Select Grade</option>
                                        </select>
                                        <div class="invalid-feedback" id="grade_id_error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="subject_id" class="form-label">
                                            Subject <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select" id="subject_id" name="subject_id" required>
                                            <option value="">Select Subject</option>
                                        </select>
                                        <div class="invalid-feedback" id="subject_id_error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1">
                                            <label class="form-check-label" for="is_active">Active Class</label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Progress Status</label>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_ongoing" name="is_ongoing" value="1">
                                            <label class="form-check-label" for="is_ongoing">Class is Ongoing</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('class_rooms.show', $id) }}" class="btn btn-secondary">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-warning" id="updateBtn">
                                            <i class="fas fa-save me-2"></i>Update Class Room
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div id="alertContainer" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const classId = {{ $id }};
    let classData = null;

    document.addEventListener('DOMContentLoaded', function () {
        loadAllData();

        document.getElementById('editClassRoomForm').addEventListener('submit', function (e) {
            e.preventDefault();
            updateClassRoom();
        });
    });

    function loadAllData() {
        clearValidationErrors();
        showLoadingState();

        loadClassData()
            .then(() => loadTeachers())
            .then(() => loadGrades())
            .then(() => loadSubjects())
            .then(() => {
                if (classData) {
                    populateForm(classData);
                }
                hideLoadingState();
            })
            .catch(error => {
                console.error('Error loading data:', error);
                showAlert('Error loading data: ' + error.message, 'danger');
                hideLoadingState();
            });
    }

    function loadClassData() {
        return fetch(`/api/class-rooms/${classId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success' && data.data) {
                    classData = data.data;
                } else {
                    throw new Error('Invalid response format');
                }
            });
    }

    function loadTeachers() {
        return fetch('/api/teachers/dropdown')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load teachers');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    const teacherSelect = document.getElementById('teacher_id');
                    while (teacherSelect.options.length > 1) {
                        teacherSelect.remove(1);
                    }

                    data.data.forEach(teacher => {
                        const option = document.createElement('option');
                        option.value = teacher.id;
                        option.textContent = `${teacher.fname} ${teacher.lname}`;
                        teacherSelect.appendChild(option);
                    });
                } else {
                    throw new Error(data.message || 'Failed to load teachers');
                }
            });
    }

    function loadGrades() {
        return fetch('/api/grades/dropdown')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load grades');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    const gradeSelect = document.getElementById('grade_id');
                    while (gradeSelect.options.length > 1) {
                        gradeSelect.remove(1);
                    }

                    data.data.forEach(grade => {
                        const option = document.createElement('option');
                        option.value = grade.id;
                        option.textContent = `Grade ${grade.grade_name}`;
                        gradeSelect.appendChild(option);
                    });
                } else {
                    throw new Error(data.message || 'Failed to load grades');
                }
            });
    }

    function loadSubjects() {
        return fetch('/api/subjects/dropdown')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load subjects');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    const subjectSelect = document.getElementById('subject_id');
                    while (subjectSelect.options.length > 1) {
                        subjectSelect.remove(1);
                    }

                    data.data.forEach(subject => {
                        const option = document.createElement('option');
                        option.value = subject.id;
                        option.textContent = subject.subject_name;
                        subjectSelect.appendChild(option);
                    });
                } else {
                    throw new Error(data.message || 'Failed to load subjects');
                }
            });
    }

    function normalizeMedium(value) {
        if (!value) return '';

        const map = {
            sinhala: 'Sinhala',
            english: 'English',
            tamil: 'Tamil',
            Sinhala: 'Sinhala',
            English: 'English',
            Tamil: 'Tamil'
        };

        return map[value] || value;
    }

    function populateForm(data) {
        document.getElementById('class_name').value = data.class_name || '';

        setTimeout(() => {
            document.getElementById('class_type').value = data.class_type || '';
            document.getElementById('medium').value = normalizeMedium(data.medium);
            document.getElementById('teacher_id').value = data.teacher_id || '';
            document.getElementById('grade_id').value = data.grade_id || '';
            document.getElementById('subject_id').value = data.subject_id || '';
            document.getElementById('is_active').checked = data.is_active == 1;
            document.getElementById('is_ongoing').checked = data.is_ongoing == 1;
        }, 300);
    }

    function updateClassRoom() {
        const updateBtn = document.getElementById('updateBtn');
        const originalText = updateBtn.innerHTML;

        clearValidationErrors();

        const formData = {
            class_name: document.getElementById('class_name').value,
            medium: document.getElementById('medium').value,
            class_type: document.getElementById('class_type').value,
            teacher_id: document.getElementById('teacher_id').value,
            subject_id: document.getElementById('subject_id').value,
            grade_id: document.getElementById('grade_id').value,
            is_active: document.getElementById('is_active').checked ? 1 : 0,
            is_ongoing: document.getElementById('is_ongoing').checked ? 1 : 0
        };

        const requiredFields = ['class_name', 'medium', 'class_type', 'teacher_id', 'subject_id', 'grade_id'];
        const missingFields = requiredFields.filter(field => !formData[field]);

        if (missingFields.length > 0) {
            showAlert(`Please fill all required fields: ${missingFields.join(', ')}`, 'warning');
            return;
        }

        updateBtn.disabled = true;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';

        fetch(`/api/class-rooms/${classId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(async response => {
            const data = await response.json();

            if (!response.ok) {
                if (response.status === 422 && data.errors) {
                    displayValidationErrors(data.errors);
                }
                throw new Error(data.message || 'Failed to update class room');
            }

            return data;
        })
        .then(data => {
            if (data.status === 'success') {
                showAlert('Class room updated successfully!', 'success');
                setTimeout(() => {
                    window.location.href = `/class-rooms/${classId}`;
                }, 1500);
            } else {
                throw new Error(data.message || 'Failed to update class room');
            }
        })
        .catch(error => {
            console.error('Error updating class room:', error);
            showAlert(error.message, 'danger');
        })
        .finally(() => {
            updateBtn.disabled = false;
            updateBtn.innerHTML = originalText;
        });
    }

    function displayValidationErrors(errors) {
        clearValidationErrors();

        Object.keys(errors).forEach(field => {
            const input = document.getElementById(field);
            const errorDiv = document.getElementById(`${field}_error`);

            if (input) {
                input.classList.add('is-invalid');
            }

            if (errorDiv) {
                errorDiv.textContent = errors[field][0];
            }
        });
    }

    function clearValidationErrors() {
        const fields = ['class_name', 'medium', 'class_type', 'teacher_id', 'grade_id', 'subject_id'];

        fields.forEach(field => {
            const input = document.getElementById(field);
            const errorDiv = document.getElementById(`${field}_error`);

            if (input) input.classList.remove('is-invalid');
            if (errorDiv) errorDiv.textContent = '';
        });
    }

    function showLoadingState() {
        const updateBtn = document.getElementById('updateBtn');
        updateBtn.disabled = true;
        updateBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
    }

    function hideLoadingState() {
        const updateBtn = document.getElementById('updateBtn');
        updateBtn.disabled = false;
        updateBtn.innerHTML = '<i class="fas fa-save me-2"></i>Update Class Room';
    }

    function showAlert(message, type) {
        const container = document.getElementById('alertContainer');
        container.innerHTML = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
    }
</script>
@endpush