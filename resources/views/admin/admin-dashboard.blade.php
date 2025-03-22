@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .dashboard-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s ease-in-out;
            text-align: center;
        }

        .dashboard-card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        }

        .icon-box {
            font-size: 30px;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            display: inline-block;
            height: 70px;
            width: 70px;
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .card-count {
            font-size: 22px;
            font-weight: bold;
        }

        .bg-blue {
            background: #007bff;
        }

        .bg-green {
            background: #28a745;
        }

        .bg-orange {
            background: #fd7e14;
        }

        .bg-red {
            background: #dc3545;
        }
    </style>
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
        </div>
        <div class="justify-content-center">
            <ol class="breadcrumb">
                <button class="btn btn-warning breadcrumb-item" data-bs-toggle="modal" data-bs-target="#uploadCsvModal">
                    Upload CSV
                </button>
            </ol>
        </div>
        
    </div>

    <!-- Dashboard Cards -->
    <div class="row">

        <!-- Today's Contacts -->
        <div class="col-md-3">
            <a href="{{ route('contacts.filter', ['filter' => 'today']) }}">
                <div class="dashboard-card">
                    <span class="icon-box bg-blue"><i class="fa-solid fa-calendar-day"></i></span>
                    <h5 class="card-title">Today's Contacts</h5>
                    <p class="card-count">{{ $todayCount }}</p>
                </div>
            </a>
        </div>
    
        <!-- Total Contacts -->
        <div class="col-md-3">
            <a href="{{ route('contacts.filter', ['filter' => 'total']) }}">
                <div class="dashboard-card">
                    <span class="icon-box bg-green"><i class="fa-solid fa-users"></i></span>
                    <h5 class="card-title">Total Contacts</h5>
                    <p class="card-count">{{ $totalCount }}</p>
                </div>
            </a>
        </div>
    
        <!-- Yearly Contacts -->
        <div class="col-md-3">
            <a href="{{ route('contacts.filter', ['filter' => 'yearly']) }}">
                <div class="dashboard-card">
                    <span class="icon-box bg-red"><i class="fa-solid fa-calendar"></i></span>
                    <h5 class="card-title">Yearly Contacts</h5>
                    <p class="card-count">{{ $yearlyCount }}</p>
                </div>
            </a>
        </div>
    
        <!-- Group Count -->
        <div class="col-md-3">
            <a href="{{ route('admin.manageGroup') }}">
                <div class="dashboard-card">
                    <span class="icon-box bg-orange"><i class="fa-solid fa-layer-group"></i></span>
                    <h5 class="card-title">Groups</h5>
                    <p class="card-count">{{ $groupCount }}</p>
                </div>
            </a>
        </div>
    
    </div>
    

    <div class="container mt-4">
        <div class="contact-card">
            <h5 class="mb-3"><i class="fa-solid fa-address-book contact-icon"></i>Today's Contact</h5>
            <div class="table-responsive  export-table">
                <table id="file-datatable" class="table table-bordered ">
                    <thead>
                        <!-- Table Headers -->
                        <tr>
                            <th>#</th>
                            <th><i class="fa-solid fa-user contact-icon"></i> Name</th>
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
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->created_at }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-info edit-btn" data-id="{{ $contact->id }}"
                                        data-name="{{ $contact->name }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>

                                    <!-- Delete Button -->
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

        </div>
    </div>
    </div>

    <!-- Edit Contact Modal -->
    <div class="modal fade" id="editContactModal" tabindex="-1" aria-labelledby="editContactModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editContactModalLabel">Edit Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editContactForm">
                        @csrf
                        <input type="hidden" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit_name" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Contact</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Upload CSV Modal -->
<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-labelledby="uploadCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.uploadCsv') }}" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="uploadCsvModalLabel">Upload Contacts CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="csv_file" class="form-label">CSV File (name, phone)</label>
                    <input type="file" name="csv_file" id="csv_file" accept=".csv" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fa fa-upload me-1"></i> Upload
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            @elseif(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33'
                });
            @endif
        });
    </script>
    
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

        // Open Edit Modal
        $(document).on("click", ".edit-btn", function() {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let phone = $(this).data("phone");

            $("#edit_id").val(id);
            $("#edit_name").val(name);
            $("#edit_phone").val(phone);
            $("#editContactModal").modal("show");
        });

        // Update Contact
        $("#editContactForm").submit(function(e) {
            e.preventDefault();
            let id = $("#edit_id").val();
            let name = $("#edit_name").val();
            let phone = $("#edit_phone").val();

            $.ajax({
                url: `/contact/update/${id}`,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    phone: phone
                },
                success: function(response) {
                    Swal.fire("Updated!", response.message, "success").then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire("Error!", xhr.responseJSON.message, "error");
                }
            });
        });
    </script>
@endsection
