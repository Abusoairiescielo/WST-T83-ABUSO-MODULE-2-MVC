@extends('layouts.dashboardTemp')
@section('title', 'Subjects')
@section('Pages')
    <span style="font-weight: 500;">Subjects</span>
@endsection
@section('content')
<div class="panel-header panel-header-sm">
</div>
<div class="content">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-4 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <h6 class="mb-0">Subject Lists</h6>
                        </div>
                        <button type="button" class="btn bg-gradient-primary btn-icon" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addSubjectModal"
                                title="Add New Subject">
                            <i class="fas fa-book"></i>
                        </button>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Subject Code</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Units</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($subjects as $subject)
                                    <tr>
                                        <td>{{ $subject->subject_code }}</td>
                                        <td>{{ $subject->name }}</td>
                                        <td>{{ $subject->description }}</td>
                                        <td>{{ $subject->units }}</td>
                                        <td>{{ $subject->schedule }}</td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-{{ $subject->deleted_at ? 'warning' : 'success' }}">
                                                {{ $subject->deleted_at ? 'Archived' : 'Active' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn bg-gradient-warning btn-icon" 
                                                    title="Edit Subject"
                                                    onclick="editSubject('{{ $subject->id }}', '{{ $subject->subject_code }}', '{{ $subject->name }}', '{{ $subject->description }}', '{{ $subject->units }}', '{{ $subject->schedule }}')">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <form id="delete-form-{{ $subject->id }}" action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn bg-gradient-danger btn-icon"
                                                        title="Delete Subject"
                                                        onclick="confirmDelete('delete-form-{{ $subject->id }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addSubjectForm" action="{{ route('subjects.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject Code</label>
                        <input type="text" class="form-control" name="subject_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Units</label>
                        <input type="number" class="form-control" name="units" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Schedule</label>
                        <input type="text" class="form-control" name="schedule">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-icon" data-bs-dismiss="modal" title="Close">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="submit" class="btn bg-gradient-primary btn-icon" title="Add Subject">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subject</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSubjectForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Subject Code</label>
                        <input type="text" class="form-control" name="subject_code" id="edit_subject_code" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Units</label>
                        <input type="number" class="form-control" name="units" id="edit_units" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Schedule</label>
                        <input type="text" class="form-control" name="schedule" id="edit_schedule">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-icon" data-bs-dismiss="modal" title="Close">
                        <i class="fas fa-times"></i>
                    </button>
                    <button type="submit" class="btn bg-gradient-warning btn-icon" title="Save Changes">
                        <i class="fas fa-save"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editSubject(id, subject_code, name, description, units, schedule) {
    const form = document.getElementById('editSubjectForm');
    form.action = `/subjects/${id}`;
    
    document.getElementById('edit_subject_code').value = subject_code;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_units').value = units;
    document.getElementById('edit_schedule').value = schedule;
    
    const editModal = new bootstrap.Modal(document.getElementById('editSubjectModal'));
    editModal.show();
}

function confirmDelete(formId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#7f1d1d',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            const form = document.getElementById(formId);
            const submitButton = form.querySelector('button[type="button"]');
            submitButton.disabled = true;
            
            const formData = new FormData();
            formData.append('_method', 'DELETE');
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    // If response is not JSON, handle it as a successful delete
                    if (response.ok) {
                        return { success: true, message: 'Subject deleted successfully' };
                    }
                    throw new Error('Failed to delete subject');
                }
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'Subject has been deleted successfully.',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message || 'Error deleting subject'
                });
            })
            .finally(() => {
                submitButton.disabled = false;
            });
        }
    });
    return false;
}

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
                location.reload();
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

// Edit Subject Form Handler
document.getElementById('editSubjectForm').addEventListener('submit', function(e) {
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
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Error updating subject'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error updating subject'
        });
    })
    .finally(() => {
        submitButton.disabled = false;
    });
});
</script>
@endpush

<style>
    /* Add Subject Button Styling */
    .card-header .btn.bg-gradient-primary {
        background: var(--gray-light);
        color: var(--dark);
        border: 1px solid rgba(0, 0, 0, 0.05);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .card-header .btn.bg-gradient-primary:hover {
        background: linear-gradient(310deg, var(--primary-orange), var(--primary-yellow));
        color: var(--light);
        border: none;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(234, 88, 12, 0.25);
    }

    /* Warning Button (Edit) */
    .btn.bg-gradient-warning {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }

    .btn.bg-gradient-warning:hover {
        background: linear-gradient(310deg, #5B21B6, #4C1D95);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(92, 33, 182, 0.3);
    }

    /* Danger Button (Delete) */
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

    /* Keep icon color white for both buttons */
    .btn.bg-gradient-warning i,
    .btn.bg-gradient-danger i {
        color: white;
    }

    /* Small Button Variants */
    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    /* Icon Styling */
    .btn i {
        font-size: 0.875rem;
    }

    /* Add spacing between buttons */
    td .btn + form {
        margin-left: 0.5rem;
    }

    .px-3 {
        padding-left: 1rem !important;
        padding-right: 1rem !important;
    }

    .me-2 {
        margin-right: 0.5rem !important;
    }

    /* Card header styling */
    .card-header .mb-0 {
        color: white !important;
    }

    /* Card header background */
    .card-header {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
        padding: 1rem;
    }

    /* Add spacing and alignment */
    .card-header .d-flex {
        align-items: center;
    }

    /* Icon-only button styles */
    .btn-icon {
        width: 32px !important;
        height: 32px !important;
        padding: 0 !important;
        min-width: unset !important;
        border-radius: 8px !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 4px !important;
    }

    .btn-icon i {
        font-size: 14px !important;
        margin: 0 !important;
    }

    /* Modal footer button styles */
    .modal-footer .btn-icon {
        width: 38px !important;
        height: 38px !important;
    }

    .modal-footer .btn-icon i {
        font-size: 16px !important;
    }

    /* Secondary button style */
    .btn.btn-secondary.btn-icon {
        background: #6B7280 !important;
        color: white !important;
    }

    .btn.btn-secondary.btn-icon:hover {
        background: #4B5563 !important;
    }

    /* Modal styling */
    .modal-content {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        background: linear-gradient(310deg, #4C1D95, #5B21B6);
        color: white;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-title {
        color: white;
        font-weight: 500;
    }

    .modal-header .btn-close {
        background-color: white;
        opacity: 0.8;
        padding: 0.5rem;
        margin: 0;
    }

    .modal-header .btn-close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.1);
        padding: 1rem;
    }

    /* Form styling */
    .form-label {
        color: #4B5563;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 0.5rem;
        padding: 0.75rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #4C1D95;
        box-shadow: 0 0 0 2px rgba(76, 29, 149, 0.1);
    }

    /* Primary button (Add/Save) - Violet theme */
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

    /* Keep icon color white */
    .btn.bg-gradient-primary i {
        color: white;
    }
</style>

@endsection