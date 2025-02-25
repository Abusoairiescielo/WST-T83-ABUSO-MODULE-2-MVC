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
                                            <button class="btn bg-gradient-warning btn-sm" 
                                                    onclick="editSubject('{{ $subject->id }}', '{{ $subject->subject_code }}', '{{ $subject->name }}', '{{ $subject->description }}', '{{ $subject->units }}', '{{ $subject->schedule }}')">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form id="delete-form-{{ $subject->id }}" action="{{ route('subjects.destroy', $subject) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn bg-gradient-danger btn-sm" 
                                                        onclick="confirmDelete('delete-form-{{ $subject->id }}')">
                                                    <i class="fas fa-trash"></i> Delete
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
                    <button type="button" class="btn bg-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-primary">Add Subject</button>
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
                    <button type="button" class="btn bg-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn bg-gradient-warning">Save Changes</button>
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
        padding: 0.6rem 1.2rem;
        font-size: 0.875rem;
        gap: 0.5rem;
    }

    /* Icon Styling */
    .btn i {
        font-size: 1.1rem;
        margin-right: 0.5rem;
        color: var(--dark);
        transition: all 0.3s ease;
    }

    /* Add spacing between action buttons */
    td .btn + .btn,
    td .btn + form,
    td form + .btn {
        margin-left: 0.5rem;
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
</style>

@endsection