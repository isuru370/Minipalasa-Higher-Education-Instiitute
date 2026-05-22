@extends('layouts.app')

@section('title', 'Class Category Fee Details')
@section('page-title', 'Class Category Fee Details')

@section('content')

    @php
        $studentClass = null;
        $category = null;

        if ($classCategoryFee) {
            $studentClass = $classCategoryFee->studentClass;
            $category = $classCategoryFee->category;
        }

        $className = '-';
        $gradeName = 'N/A';
        $subjectName = 'N/A';
        $teacherName = 'N/A';
        $classStatus = false;

        if ($studentClass) {
            if ($studentClass->class_name) {
                $className = $studentClass->class_name;
            }

            if ($studentClass->grade) {
                if ($studentClass->grade->grade_name) {
                    $gradeName = $studentClass->grade->grade_name;
                }
            }

            if ($studentClass->subject) {
                if ($studentClass->subject->subject_name) {
                    $subjectName = $studentClass->subject->subject_name;
                }
            }

            if ($studentClass->teacher) {
                if ($studentClass->teacher->full_name) {
                    $teacherName = $studentClass->teacher->full_name;
                }
            }

            if ($studentClass->is_active) {
                $classStatus = true;
            }
        }

        $categoryName = '-';
        $categoryCode = '-';
        $categoryStatus = false;

        if ($category) {
            if ($category->category_name) {
                $categoryName = $category->category_name;
            }

            if ($category->code) {
                $categoryCode = $category->code;
            }

            if ($category->is_active) {
                $categoryStatus = true;
            }
        }
    @endphp

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                <h5 class="mb-0 fw-bold">
                    Class Category Fee Details
                </h5>

                <small class="text-muted">
                    {{ $className }} / {{ $categoryName }}
                </small>
            </div>

            <div class="d-flex gap-2 flex-wrap">

                @if($classStatus)
                    <a href="{{ route('admin.class-category-fees.edit', $classCategoryFee) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>
                @endif

                <a href="{{ route('admin.class-category-fees.index') }}" class="btn btn-outline-secondary btn-sm">
                    Back
                </a>

            </div>

        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="row g-4">

                <div class="col-md-6">
                    <div class="border rounded-4 p-3 h-100">

                        <h6 class="fw-bold mb-3">
                            Class Information
                        </h6>

                        <p>
                            <strong>Class:</strong>
                            {{ $className }}
                        </p>

                        <p>
                            <strong>Grade:</strong>
                            {{ $gradeName }}
                        </p>

                        <p>
                            <strong>Subject:</strong>
                            {{ $subjectName }}
                        </p>

                        <p>
                            <strong>Teacher:</strong>
                            {{ $teacherName }}
                        </p>

                        <p class="mb-0">
                            <strong>Class Status:</strong>

                            <span class="badge {{ $classStatus ? 'bg-success' : 'bg-secondary' }}">
                                {{ $classStatus ? 'Active' : 'Inactive' }}
                            </span>
                        </p>

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="border rounded-4 p-3 h-100">

                        <h6 class="fw-bold mb-3">
                            Category Information
                        </h6>

                        <p>
                            <strong>Category:</strong>
                            {{ $categoryName }}
                        </p>

                        <p>
                            <strong>Category Code:</strong>
                            <span class="badge bg-light text-dark border">
                                {{ $categoryCode }}
                            </span>
                        </p>

                        <p class="mb-0">
                            <strong>Category Status:</strong>

                            <span class="badge {{ $categoryStatus ? 'bg-success' : 'bg-secondary' }}">
                                {{ $categoryStatus ? 'Active' : 'Inactive' }}
                            </span>
                        </p>

                    </div>
                </div>

                <div class="col-12">
                    <div class="border rounded-4 p-3">

                        <h6 class="fw-bold mb-3">
                            Fee Information
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <p class="mb-0">
                                    <strong>Fee:</strong>
                                    {{ number_format($classCategoryFee->fee, 2) }}
                                </p>
                            </div>

                            <div class="col-md-4">
                                <p class="mb-0">
                                    <strong>Fee Status:</strong>

                                    <span class="badge {{ $classCategoryFee->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $classCategoryFee->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>

                            <div class="col-md-4">
                                <p class="mb-0">
                                    <strong>ID:</strong>
                                    #{{ $classCategoryFee->id }}
                                </p>
                            </div>

                            <div class="col-12">
                                <p class="mb-0">
                                    <strong>Note:</strong>

                                    @if($classCategoryFee->note)
                                        {{ $classCategoryFee->note }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-0">
                                    <strong>Created At:</strong>

                                    @if($classCategoryFee->created_at)
                                        {{ $classCategoryFee->created_at->format('Y-m-d h:i A') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <div class="col-md-6">
                                <p class="mb-0">
                                    <strong>Updated At:</strong>

                                    @if($classCategoryFee->updated_at)
                                        {{ $classCategoryFee->updated_at->format('Y-m-d h:i A') }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection