@extends('layouts.app')

@section('content')

@section('styles')

    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        .custom-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .group-dropdown {
            width: 250px;
        }

        .assign-btn {
            background: rgb(123, 29, 112);
            color: #fff;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>

@endsection

@section('content')

    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ASSIGN GROUP</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Group</a></li>
                <li class="breadcrumb-item active" aria-current="page">Assign Group</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        </script>
    @endif

    <div class="container mt-4">
        <div class="contact-card">
            <h5 class="mb-3"><i class="fa-solid fa-address-book contact-icon"></i>Group Name</h5>
            <form id="assign-form">
                <div class="table-responsive export-table">
                    <table id="file-datatable" class="table table-bordered">
                        <thead>
                            <tr>
                                <div style="width: 600px" class="d-flex justify-content-between align-items-center mb-3">
                                    <select id="group-select" class="form-control group-dropdown">
                                        <option value="">Select Group</option>

                                        @foreach ($groups as $group)
                                        <option value="{{ $group->group_id }}">{{ $group->group_name }}</option>
                                        @endforeach
                                    
                                    </select>
                                    <button type="button" class="assign-btn" style="width: 200px" id="assign-group-btn">
                                        <i class="fa-solid fa-user-plus"></i> Save
                                    </button>
                                </div>
                            </tr>
                            <tr>
                                <th>#</th>
                                <th>
                                    <input type="checkbox" id="select-all"
                                        style="margin-right: 10px; transform: scale(1.5);"> Select All
                                </th>
                                <th><i class="fa-solid fa-user contact-icon"></i> Name</th>
                                <th><i class="fa-solid fa-phone contact-icon"></i> Phone</th>
                                <th><i class="fa-solid fa-calendar contact-icon"></i> Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($manageContact as $index => $contact)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><input type="checkbox" class="contact-checkbox" value="{{ $contact->contact_id }}">
                                    </td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->created_at }}</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No contacts available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </form>


        </div>
    </div>

@endsection

@section('scripts')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            let checkboxes = document.querySelectorAll('.contact-checkbox');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
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

    <!-- INTERNAL Select2 js -->
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Select/Deselect all checkboxes when "Select All" is clicked
            $("#select-all").change(function() {
                $(".contact-checkbox").prop("checked", this.checked);
            });

            // Assign selected contacts to a group
            $("#assign-group-btn").click(function() {
                let groupId = $("#group-select").val();
                let contactIds = [];

                // Collect all checked contact IDs
                $(".contact-checkbox:checked").each(function() {
                    contactIds.push($(this).val());
                });

                // Validation: Ensure a group and at least one contact is selected
                if (groupId === "" || contactIds.length === 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "Oops...",
                        text: "Please select a group and at least one contact!"
                    });
                    return;
                }

                // Send data via AJAX
                $.ajax({
                    url: "{{ route('assign.contacts') }}",
                    type: "POST",
                    data: {
                        group_id: groupId,
                        contact_ids: contactIds,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: response.success
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: xhr.responseJSON ? xhr.responseJSON.error :
                                "Something went wrong!"
                        });
                    }
                });
            });
        });
    </script>
@endsection
