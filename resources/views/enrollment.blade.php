@extends('layouts.dashboardTemp')
@section('title', 'Enrollment')
@section('Pages')
    <span style="font-weight: 500;">Enrollment</span>
@endsection
@section('content')
<!-- Add these lines for DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css">
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Available Students</h6>
                       
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="availableStudentsTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        @if($student->enrollment_status === 'ready')
                                        <tr>
                                            <td>{{ $student->student_id }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>
                                                <button class="btn bg-gradient-warning btn-sm" 
                                                        onclick="enrollStudent({{ $student->id }})" 
                                                        title="Enroll Student">
                                                    <i class="fas fa-user-plus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Enrolled Students Section -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Enrolled Students</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="enrolledStudentsTable" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Enrolled Subjects</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($enrolledStudents as $student)
                                    <tr>
                                        <td>{{ $student->student_id }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>
                                            @foreach($student->subjects as $subject)
                                                <span class="badge bg-primary">{{ $subject->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="text-end">
                                            <div class="btn-group">
                                                <button class="btn bg-gradient-warning btn-icon me-2" onclick="manageSubjects({{ $student->id }})" title="Manage Subjects">
                                                    <i class="fas fa-book"></i>
                                                </button>
                                                <button class="btn bg-gradient-danger btn-icon" onclick="unenrollStudent({{ $student->id }})" title="Unenroll Student">
                                                    <i class="fas fa-user-minus"></i>
                                                </button>
                                            </div>
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
</div>

<!-- Manage Subjects Modal -->
<div class="modal fade" id="manageSubjectsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">Manage Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="subjectForm" action="{{ route('enrollment.subjects') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="modalStudentId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Subjects to Enroll</label>
                        @foreach($subjects as $subject)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" 
                                   value="{{ $subject->id }}" id="subject{{ $subject->id }}">
                            <label class="form-check-label" for="subject{{ $subject->id }}">
                                {{ $subject->name }} ({{ $subject->subject_code }})
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-icon" data-bs-dismiss="modal" title="Close">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="submit" class="btn bg-gradient-primary btn-icon" title="Save Changes">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Enrollment Modal -->
<div class="modal fade" id="enrollmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white">
                    <i class="fas fa-user-plus me-2"></i>
                    Enroll Student
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="enrollmentForm" action="{{ route('enrollment.enroll') }}" method="POST">
                @csrf
                <input type="hidden" name="student_id" id="enrollStudentId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Subjects</label>
                        @foreach($subjects as $subject)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="subjects[]" 
                                   value="{{ $subject->id }}" id="enrollSubject{{ $subject->id }}">
                            <label class="form-check-label" for="enrollSubject{{ $subject->id }}">
                                {{ $subject->name }} ({{ $subject->subject_code }})
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-light" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2" style="color: #344767;"></i>
                    </button>
                    <button type="submit" class="btn bg-gradient-warning">
                        <i class="fas fa-user-plus me-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-gradient-warning {
        background: linear-gradient(310deg, #ea580c, #facc15);
        color: white;
        border: none;
    }
    
    .bg-gradient-warning:hover {
        background: linear-gradient(310deg, #c2410c, #eab308);
        transform: translateY(-1px);
    }

    .bg-gradient-primary {
        background: linear-gradient(310deg, #ea580c, #facc15);
        color: white;
        border: none;
    }

    .bg-gradient-primary:hover {
        background: linear-gradient(310deg, #c2410c, #eab308);
        transform: translateY(-1px);
    }

    .badge.bg-primary {
        background: linear-gradient(310deg, #ea580c, #facc15) !important;
    }

    /* Enroll Button Styling */
    .btn.bg-gradient-warning {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn.bg-gradient-warning:hover {
        background: linear-gradient(310deg, #5B21B6, #4C1D95);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(91, 33, 182, 0.3);
    }

    /* Keep icon color white */
    .btn.bg-gradient-warning i {
        color: white;
    }

    /* Manage Subjects Button - Violet theme */
    .btn.bg-gradient-primary {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn.bg-gradient-primary:hover {
        background: linear-gradient(310deg, #5B21B6, #4C1D95);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(91, 33, 182, 0.3);
    }

    /* Subject Badge Styling */
    .badge.bg-primary {
        background: linear-gradient(310deg, #4C1D95, #5B21B6) !important;
        color: white;
        border: none;
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 500;
        margin: 0.25rem;
        transition: all 0.3s ease;
    }

    .badge.bg-primary:hover {
        background: linear-gradient(310deg, #5B21B6, #4C1D95) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(91, 33, 182, 0.3);
    }

    /* Card header styling */
    .card-header h6 {
        color: white !important;
    }

    /* Card header background */
    .card-header {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
    }

    /* Danger Button (Unenroll) */
    .btn.bg-gradient-danger {
        background: linear-gradient(310deg, #dc2626, #ef4444);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn.bg-gradient-danger:hover {
        background: linear-gradient(310deg, #ef4444, #dc2626);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Button spacing */
    .ms-2 {
        margin-left: 0.5rem !important;
    }

    /* Icon spacing */
    .me-2 {
        margin-right: 0.5rem !important;
    }

    /* Keep icon colors white */
    .btn i {
        color: white;
    }

    /* Icon Button Styling */
    .btn.btn-sm {
        width: 32px;
        height: 32px;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn.btn-sm i {
        font-size: 14px;
    }

    /* Modal Header Styling */
    .modal-header {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
        color: white;
    }

    .modal-header .btn-close {
        filter: brightness(0) invert(1);
    }

    .modal-title i {
        color: white;
    }

    /* Light button icon color */
    .btn.bg-light i {
        color: #344767;
    }

    .btn.bg-light:hover i {
        color: #344767;
    }

    /* Action buttons container */
    td .btn-icon + .btn-icon {
        margin-left: 8px;
    }

    /* Hover effects for action buttons */
    .btn-icon.bg-gradient-warning:hover {
        background: linear-gradient(310deg, #5B21B6, #4C1D95);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(91, 33, 182, 0.3);
    }

    .btn-icon.bg-gradient-danger:hover {
        background: linear-gradient(310deg, #ef4444, #dc2626);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
    }

    /* Ensure icons are centered */
    .btn-icon i {
        margin: 0 !important;
        font-size: 14px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Base button styles */
    .btn {
        transition: all 0.3s ease;
        border: none;
    }

    /* Icon button specific styles */
    .btn-icon {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    /* Remove transform effects */
    .btn:hover,
    .btn:focus,
    .btn:active,
    .btn-icon:hover,
    .btn-icon:focus,
    .btn-icon:active {
        transform: none !important;
    }

    /* Warning/Primary button (violet theme) */
    .btn.bg-gradient-warning,
    .btn.bg-gradient-primary {
        background: linear-gradient(310deg, #4C1D95, #5B21B6) !important;
        color: white !important;
    }

    .btn.bg-gradient-warning:hover,
    .btn.bg-gradient-primary:hover {
        background: linear-gradient(310deg, #5B21B6, #4C1D95) !important;
        box-shadow: 0 4px 12px rgba(91, 33, 182, 0.3) !important;
    }

    /* Danger button */
    .btn.bg-gradient-danger {
        background: linear-gradient(310deg, #dc2626, #ef4444) !important;
        color: white !important;
    }

    .btn.bg-gradient-danger:hover {
        background: linear-gradient(310deg, #ef4444, #dc2626) !important;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3) !important;
    }

    /* Secondary button */
    .btn.btn-secondary {
        background: #6B7280 !important;
        color: white !important;
    }

    .btn.btn-secondary:hover {
        background: #4B5563 !important;
        box-shadow: 0 4px 12px rgba(75, 85, 99, 0.3) !important;
    }

    /* Icon styles */
    .btn i {
        font-size: 14px !important;
        margin: 0 !important;
    }

    /* Button group styling */
    .btn-group {
        display: inline-flex;
        gap: 0.5rem;
        align-items: center;
    }

    /* Table cell alignment */
    .text-end {
        text-align: right !important;
    }

    /* Remove old button spacing */
    td .btn-icon + .btn-icon {
        margin-left: 0;
    }
</style>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
<script>
function enrollStudent(studentId) {
    document.getElementById('enrollStudentId').value = studentId;
    const enrollmentModal = new bootstrap.Modal(document.getElementById('enrollmentModal'));
    enrollmentModal.show();
}

document.getElementById('enrollmentForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Check if at least one subject is selected
    const selectedSubjects = this.querySelectorAll('input[name="subjects[]"]:checked');
    if (selectedSubjects.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'No Subjects Selected',
            text: 'Please select subject to enroll the student.',
            confirmButtonColor: '#4C1D95'
        });
        return;
    }

    // Disable submit button to prevent double submission
    const submitButton = this.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: new FormData(this),
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => {
        console.log('Response:', response);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Data:', data);
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            let errorMessage = 'An error occurred while enrolling the student.';
            
            // Handle specific error cases
            if (data.error === 'no_subjects') {
                errorMessage = 'Please select at least one subject to enroll the student.';
            } else if (data.error === 'already_enrolled') {
                errorMessage = 'Student is already enrolled in one or more of the selected subjects.';
            } else if (data.error === 'capacity_full') {
                errorMessage = 'One or more selected subjects have reached their maximum capacity.';
            } else if (data.error === 'schedule_conflict') {
                errorMessage = 'There is a schedule conflict with the selected subjects.';
            } else if (data.error === 'prerequisites') {
                errorMessage = 'Prerequisites are not met for one or more selected subjects.';
            } else if (data.message) {
                errorMessage = data.message;
            }

            Swal.fire({
                icon: 'error',
                title: 'Enrollment Error',
                text: errorMessage,
                confirmButtonColor: '#4C1D95'
            });
        }
    })
    .catch(error => {
        console.error('Enrollment error:', error);
        Swal.fire({
            icon: 'error',
            title: 'System Error',
            text: 'An unexpected error occurred. Please try again or contact support if the problem persists.',
            confirmButtonColor: '#4C1D95'
        });
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});

function manageSubjects(studentId) {
    document.getElementById('modalStudentId').value = studentId;
    
    // Fetch current subjects for this student
    fetch(`/api/student/${studentId}/subjects`)
        .then(response => response.json())
        .then(enrolledSubjects => {
            // Reset all checkboxes
            document.querySelectorAll('input[name="subjects[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Check the boxes for enrolled subjects
            enrolledSubjects.forEach(subjectId => {
                const checkbox = document.getElementById(`subject${subjectId}`);
                if (checkbox) checkbox.checked = true;
            });
            
            // Show the modal
            const manageModal = new bootstrap.Modal(document.getElementById('manageSubjectsModal'));
            manageModal.show();
        });
}

document.getElementById('subjectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Check if at least one subject is selected
    const selectedSubjects = this.querySelectorAll('input[name="subjects[]"]:checked');
    if (selectedSubjects.length === 0) {
        Swal.fire({
            icon: 'warning',
            title: 'Subject Selection Required',
            text: 'Please select at least one subject to manage enrollment.',
            confirmButtonColor: '#4C1D95',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Disable submit button to prevent double submission
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
                text: 'Subject enrollment has been updated successfully.',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                location.reload();
            });
        } else {
            let errorTitle = 'Subject Management Error';
            let errorMessage = 'Please check your subject selection and try again.';

            // More specific error messages based on the error type
            if (data.error === 'no_subjects') {
                errorTitle = 'No Subjects Selected';
                errorMessage = 'Please select at least one subject to proceed with enrollment.';
            } else if (data.error === 'invalid_selection') {
                errorTitle = 'Invalid Subject Selection';
                errorMessage = 'The selected combination of subjects is not valid. Please review your selection.';
            } else if (data.error === 'schedule_conflict') {
                errorTitle = 'Schedule Conflict Detected';
                errorMessage = 'There are schedule conflicts with the selected subjects. Please choose different subjects.';
            }

            Swal.fire({
                icon: 'error',
                title: errorTitle,
                text: errorMessage,
                confirmButtonColor: '#4C1D95',
                confirmButtonText: 'Try Again'
            });
        }
    })
    .catch(error => {
        console.error('Subject management error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Unable to Update Subjects',
            text: 'There was a problem updating the subject enrollment. Please try again or contact support if the issue persists.',
            confirmButtonColor: '#4C1D95',
            confirmButtonText: 'OK'
        });
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});

function unenrollStudent(studentId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will unenroll the student from all subjects!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#800000',  // Maroon color
        cancelButtonColor: '#6B7280',   // Gray color
        confirmButtonText: 'Yes, unenroll!',
        cancelButtonText: 'Cancel',
        buttonsStyling: true,
        customClass: {
            confirmButton: 'swal2-confirm',
            cancelButton: 'swal2-cancel'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Disable the button to prevent double submission
            const button = event.target.closest('button');
            button.disabled = true;
            
            fetch(`/enrollment/unenroll/${studentId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
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
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while unenrolling the student'
                });
            })
            .finally(() => {
                button.disabled = false;
            });
        }
    });
}

$(document).ready(function() {
    // Initialize Available Students DataTable
    $('#availableStudentsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search students...",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        }
    });

    // Initialize Enrolled Students DataTable
    $('#enrolledStudentsTable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        order: [[0, 'asc']],
        responsive: true,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search enrolled students...",
            paginate: {
                previous: '<i class="fas fa-chevron-left"></i>',
                next: '<i class="fas fa-chevron-right"></i>'
            }
        }
    });
});
</script>

<style>
/* DataTables Custom Styling */
.dataTables_wrapper {
    padding: 20px;
}

.dataTables_length {
    margin-bottom: 15px;
}

.dataTables_length select {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 30px 6px 10px;
    margin: 0 5px;
    background-color: white;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M8 11l-4-4h8l-4 4z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 10px center;
}

.dataTables_filter {
    margin-bottom: 15px;
}

.dataTables_filter input {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 6px 12px;
    margin-left: 8px;
    width: 200px;
}

.dataTables_info {
    padding-top: 10px;
}

.dataTables_paginate {
    padding-top: 10px;
}

/* Pagination Styling */
.dataTables_wrapper .paginate_button {
    padding: 8px 12px;
    margin: 0 2px;
    border-radius: 4px;
    border: 1px solid #ddd;
    background: white;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 38px;
    transition: all 0.3s ease;
}

.dataTables_wrapper .paginate_button.current {
    background: linear-gradient(310deg, #4C1D95, #5B21B6);
    color: white !important;
    border: none;
}

/* Update the icon styles */
.dataTables_wrapper .paginate_button i {
    font-size: 16px;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Update the arrow button styles */
.dataTables_wrapper .paginate_button.previous,
.dataTables_wrapper .paginate_button.next {
    padding: 0;
    min-width: 38px;
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 4px;
    border: 1px solid #ddd;
}

.dataTables_wrapper .paginate_button:hover:not(.current):not(.disabled) {
    background: linear-gradient(310deg, #4C1D95, #5B21B6);
    color: white !important;
    border-color: transparent;
    transform: translateY(-1px);
    box-shadow: 0 4px 6px rgba(76, 29, 149, 0.1);
}

.dataTables_wrapper .paginate_button.disabled {
    background: #f5f5f5;
    cursor: not-allowed;
    opacity: 0.6;
}

/* Table Styling */
.table thead th {
    font-weight: 600;
    padding: 12px 16px;
    border-bottom: 2px solid #ddd;
}

.table tbody td {
    padding: 12px 16px;
    vertical-align: middle;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dataTables_length,
    .dataTables_filter {
        text-align: left;
        width: 100%;
    }
    
    .dataTables_filter input {
        width: 100%;
        margin-left: 0;
        margin-top: 5px;
    }
}
</style>
@endpush