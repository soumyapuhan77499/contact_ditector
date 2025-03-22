@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .contact-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease-in-out;
        }

        .contact-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .table thead {
            background: #007bff;
            color: white;
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .contact-icon {
            font-size: 18px;
            margin-right: 5px;
            color: #007bff;
        }

        .group-header {
            background: #007bff;
            color: #fff;
            text-align: left;
            font-weight: bold;
            padding: 10px;
        }

        .group-header button {
            background: #0056b3;
            border: none;
            padding: 8px 15px;
            font-size: 14px;
            border-radius: 5px;
            cursor: pointer;
        }

        .group-header button:hover {
            background: #00408a;
        }

        .contact-icon {
            margin-right: 5px;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        #select-all {
            cursor: pointer;
        }

        th {
            color: black;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE CONTACT DETAILS</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"> <button class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#addContactModal">Add Contact</button></li>
            </ol>
        </div>
    </div>

    <!-- Add Contact Modal -->
    <div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('admin.addContact') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Contact</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    <!-- Contact List Card -->
    <div class="container mt-4">
        <div class="contact-card">

            <!-- Header Row: Title + Filter Form -->
            <form method="GET" action="{{ route('admin.manageContact') }}" class="row g-3 align-items-end mb-4">
                <!-- Title -->
                <div class="col-md-3 d-flex align-items-center">
                    <h5 class="mb-0">
                        <i class="fa-solid fa-address-book contact-icon me-2"></i> Contact List
                    </h5>
                </div>

                <!-- From Date -->
                <div class="col-md-2">
                    <label for="from_date" class="form-label">From</label>
                    <input type="date" id="from_date" name="from_date" class="form-control"
                        value="{{ request('from_date') }}">
                </div>

                <!-- To Date -->
                <div class="col-md-2">
                    <label for="to_date" class="form-label">To</label>
                    <input type="date" id="to_date" name="to_date" class="form-control"
                        value="{{ request('to_date') }}">
                </div>

                <!-- Buttons -->
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa fa-filter me-1"></i> Filter
                        </button>
                        <a href="{{ route('admin.manageContact') }}" class="btn btn-secondary w-100">
                            Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Contact Table -->
            <div class="table-responsive export-table">
                <table id="file-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><i class="fa-solid fa-user contact-icon"></i> Name</th>
                            <th><i class="fa-solid fa-users contact-icon"></i> Group Name</th>
                            <th><i class="fa-solid fa-phone contact-icon"></i> Phone</th>
                            <th><i class="fa-solid fa-calendar contact-icon"></i> Date</th>
                            <th><i class="fa-solid fa-cogs contact-icon"></i> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($manageContact as $index => $contact)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->group_names ?? 'N/A' }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ \Carbon\Carbon::parse($contact->created_at)->format('d M Y') }}</td>
                                <td>

                                    <button class="btn btn-sm btn-info edit-btn" data-id="{{ $contact->id }}"
                                        data-contactid="{{ $contact->contact_id }}" data-name="{{ $contact->name }}"
                                        data-group="{{ $contact->group_id ?? '' }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>


                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $contact->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No contacts available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


            <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Contact</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editContactForm">
                                @csrf
                                <input type="hidden" id="edit_id" name="edit_id">
                                <input type="hidden" id="edit_contact_id" name="contact_id"> {{-- 🔧 New hidden field --}}

                                <div class="mb-3">
                                    <label for="edit_name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="group-select" class="form-label">Group</label>
                                    <select id="group-select" class="form-control" name="group_id" required>
                                        <option value="">Select Group</option>
                                        @foreach ($groups as $group)
                                            <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Contact</button>
                                </div>
                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@section('scripts')
    <!-- Internal Data tables -->
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/js/table-data.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Delete Contact
        $(document).on("click", ".delete-btn", function() {
            let id = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "This will mark the contact as deleted!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/contact/delete/${id}`,
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire("Deleted!", response.message, "success").then(() =>
                                location.reload());
                        },
                        error: function(xhr) {
                            Swal.fire("Error!", xhr.responseJSON.message, "error");
                        }
                    });
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            let id = $(this).data('id');
            let contactId = $(this).data('contactid');
            let name = $(this).data('name');
            let groupId = $(this).data('group');

            $('#edit_id').val(id);
            $('#edit_contact_id').val(contactId); // ✅ now set directly
            $('#edit_name').val(name);
            $('#group-select').val(groupId);

            $('#editContactModal').modal('show');
        });


        $("#editContactForm").submit(function(e) {
    e.preventDefault();

    // Clear any previous error messages
    $('.text-danger').remove();

    let id = $("#edit_id").val();
    let contactId = $('#edit_contact_id').val();
    let name = $("#edit_name").val();
    let groupId = $("#group-select").val();

    $.ajax({
        url: `/contact/update/${id}`,
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            name: name,
            contact_id: contactId,
            group_id: groupId
        },
        success: function(response) {
            Swal.fire("Updated!", response.message, "success").then(() => location.reload());
        },
        error: function(xhr) {
            if (xhr.status === 422 && xhr.responseJSON.errors) {
                let errors = xhr.responseJSON.errors;

                if (errors.name) {
                    $('#edit_name').after('<small class="text-danger">' + errors.name[0] + '</small>');
                }

                if (errors.group_id) {
                    $('#group-select').after('<small class="text-danger">' + errors.group_id[0] + '</small>');
                }

                if (errors.contact_id) {
                    $('#edit_contact_id').after('<small class="text-danger">' + errors.contact_id[0] + '</small>');
                }
            } else {
                Swal.fire("Error!", xhr.responseJSON?.message || "Something went wrong", "error");
            }
        }
    });
});


    </script>
@endsection
