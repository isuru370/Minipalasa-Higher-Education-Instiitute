@extends('layouts.app')

@section('title', 'Admissions')
@section('page-title', 'Admissions')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Admissions</h3>
            <p class="text-muted mb-0">
                Manage admission fees and settings
            </p>
        </div>

        <a href="{{ route('admin.admissions.create') }}"
           class="btn btn-primary rounded-pill px-4">
            <i class="fas fa-plus me-2"></i>
            Add Admission
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success rounded-4 border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.admissions.index') }}"
                  class="mb-4">

                <div class="row g-3">

                    <div class="col-md-10">
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               class="form-control rounded-4"
                               placeholder="Search admissions...">
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-dark w-100 rounded-4">
                            Search
                        </button>
                    </div>

                </div>

            </form>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Note</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($admissions as $admission)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $admission->name }}
                                </td>

                                <td>
                                    Rs. {{ number_format($admission->amount, 2) }}
                                </td>

                                <td>
                                    @if($admission->is_active)
                                        <span class="badge bg-success">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $admission->note ?? '-' }}
                                </td>

                                <td>

                                    <div class="d-flex gap-2">

                                        <a href="{{ route('admin.admissions.show', $admission) }}"
                                           class="btn btn-sm btn-info rounded-pill">
                                            View
                                        </a>

                                        <a href="{{ route('admin.admissions.edit', $admission) }}"
                                           class="btn btn-sm btn-warning rounded-pill">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.admissions.destroy', $admission) }}"
                                              method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    onclick="return confirm('Delete this admission?')"
                                                    class="btn btn-sm btn-danger rounded-pill">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6"
                                    class="text-center py-5 text-muted">
                                    No admissions found
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-4">
                {{ $admissions->links() }}
            </div>

        </div>

    </div>

</div>

@endsection