@extends('layouts.dashboardTemp')

@section('title', 'Dashboard')
@section('Pages', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header pb-0 text-white">
                    <h6 class="mb-4">Student Management</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row mb-4">
                        <!-- Total Students Stats -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="stats-card bg-gradient-primary">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Total Students</p>
                                                <h5 class="font-weight-bolder text-white mb-0">{{ $totalStudents }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-white shadow-light text-center rounded-circle">
                                                <i class="fas fa-users text-lg text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Active Students Stats -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="stats-card bg-gradient-success">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-8">
                                            <div class="numbers">
                                                <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Active Students</p>
                                                <h5 class="font-weight-bolder text-white mb-0">{{ $activeStudents }}</h5>
                                            </div>
                                        </div>
                                        <div class="col-4 text-end">
                                            <div class="icon icon-shape bg-white shadow-light text-center rounded-circle">
                                                <i class="fas fa-user-check text-lg text-success"></i>
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

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Recent Students</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7">Student ID</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Email</th>
                                    <th class="text-uppercase text-white text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentStudents as $student)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $student->student_id }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $student->name }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $student->email }}</p>
                                    </td>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ $student->status === 'active' ? 'success' : 'secondary' }}">
                                            {{ $student->status }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Subject Modal -->
@include('Subjects.partials.add-subject-modal')

@push('scripts')
<script>

// Add Subject Form Handler
document.getElementById('addSubjectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '{{ route("subjects.index") }}';
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Error adding subject'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error adding subject'
        });
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});
</script>
@endpush

<style>
      .btn.bg-gradient-primary {
        background: linear-gradient(310deg, #5e72e4, #825ee4);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
    }

    .btn.bg-gradient-primary:hover {
        background: linear-gradient(310deg, #825ee4, #5e72e4);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(94, 114, 228, 0.3);
    }

    .btn.bg-gradient-primary i {
        margin-right: 0.5rem;
        color: white;
    }
/* Color Variables */
:root {
    --primary-orange: #ea580c;
    --primary-yellow: #facc15;
    --dark-orange: #c2410c;
    --dark-yellow: #eab308;
    --dark: #1a1a1a;
    --light: #ffffff;
}

/* Card Styling */
.card {
    background: var(--light);
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(234, 88, 12, 0.15);
}

.card-header {
    background: linear-gradient(310deg, var(--primary-orange), var(--primary-yellow));
    color: var(--light);
    border: none;
}

/* Table Styling */
.table thead th {
    background: var(--dark);
    color: var(--light);
    border-bottom: none;
}

.table tbody tr:hover {
    background: rgba(234, 88, 12, 0.05);
}

/* Badge Styling */
.bg-gradient-success {
    background: linear-gradient(310deg, #059669, #10b981);
}

.bg-gradient-secondary {
    background: linear-gradient(310deg, #4b5563, #6b7280);
}

/* Text Styling */
.text-xs {
    color: var(--dark);
}

.text-sm {
    font-weight: 500;
}

/* Stats Card */
.stats-card {
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
}

.bg-gradient-primary {
    background: linear-gradient(310deg, #5e72e4, #825ee4);
}

.bg-gradient-success {
    background: linear-gradient(310deg, #2dce89, #2dcecc);
}

.icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.icon-shape i {
    font-size: 1.25rem;
}

.text-primary {
    color: #5e72e4 !important;
}

.text-success {
    color: #2dce89 !important;
}

/* Stats Card Styling */
.stats-card {
    border-radius: 1rem;
    transition: all 0.3s ease;
}

.stats-card .icon-shape {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.stats-card .icon-shape i {
    font-size: 1.25rem;
    line-height: 1;
}

.shadow-light {
    box-shadow: 0 0 20px rgba(255, 255, 255, 0.1);
}

/* Navigation Button Styling */
.navbar-nav .nav-link {
    padding: 0.75rem 1rem;
    margin: 0.5rem 1rem;
    border-radius: 0.5rem;
    width: calc(100% - 2rem);
    transition: all 0.3s ease;
}

.navbar-nav .nav-item {
    width: 100%;
}

.navbar-nav .icon-shape {
    width: 32px;
    height: 32px;
}

.card-header h6 {
    color: white !important;
}

.modal-footer .btn.bg-gradient-primary {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    margin-bottom: 0;
    border-radius: 0.5rem;
}

.modal-footer .btn.bg-gradient-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 3px 8px rgba(94, 114, 228, 0.2);
}

/* Icon-only button styles */
.btn-icon {
    width: 38px !important;
    height: 38px !important;
    padding: 0 !important;
    min-width: unset !important;
    border-radius: 8px !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 4px !important;
}

.btn-icon i {
    font-size: 16px !important;
    margin: 0 !important;
}

/* Remove margin bottom for quick action buttons */
.col-xl-6 .btn-icon {
    margin-bottom: 0 !important;
}

/* Secondary button style */
.btn.btn-secondary.btn-icon {
    background: #6B7280 !important;
    color: white !important;
}

.btn.btn-secondary.btn-icon:hover {
    background: #4B5563 !important;
}

/* Hover effects */
.btn-icon:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(94, 114, 228, 0.3);
}
</style>
@endsection