@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header d-flex justify-content-between align-items-center">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE GROUP</span>
    </div>

    <div class="d-flex align-items-center">
        <a href="{{ route('admin.addGroup') }}" class="btn btn-primary me-3">
            <i class="fa fa-plus"></i> Add Group
        </a>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="javascript:void(0);">Group</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Group</li>
        </ol>
    </div>
</div>



    <div class="container mt-4">
        <div class="contact-card">
            <h5 class="mb-3"><i class="fa-solid fa-address-book contact-icon"></i> Group List</h5>
            <div class="table-responsive export-table">
                <table id="file-datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Group Name</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($groups as $index => $group)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $group->group_name }}</td>
                                <td>{{ $group->description }}</td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-sm btn-info edit-btn"
                                        data-id="{{ $group->id }}"
                                        data-group_name="{{ $group->group_name }}"
                                        data-description="{{ $group->description }}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>

                                    <!-- Delete Button -->
                                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $group->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No Groups available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Group</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editGroupForm">
                    @csrf
                    <input type="hidden" id="edit_group_id">
                    <div class="form-group">
                        <label for="edit_group_name">Group Name</label>
                        <input type="text" class="form-control" id="edit_group_name" name="group_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/table-data.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            // Open Edit Modal
            $('.edit-btn').click(function () {
                $('#edit_group_id').val($(this).data('id'));
                $('#edit_group_name').val($(this).data('group_name'));
                $('#edit_description').val($(this).data('description'));
                $('#editGroupModal').modal('show');
            });

            // Update Group
            $('#editGroupForm').submit(function (e) {
                e.preventDefault();
                let id = $('#edit_group_id').val();
                $.ajax({
                    url: `/admin/groups/update/${id}`,
                    type: "POST",
                    data: $(this).serialize(),
                    success: function (response) {
                        if (response.success) {
                            Swal.fire("Updated!", response.message, "success").then(() => location.reload());
                        }
                    }
                });
            });

            // Delete Group
          
        });
    </script>

<script>
  $(document).on("click", ".delete-btn", function () {
    let id = $(this).data("id");

    Swal.fire({
        title: "Are you sure?",
        text: "This will mark the group as deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/groups/delete/${id}`,
                type: "POST", // Change DELETE to POST
                data: {
                    _method: "DELETE", // Laravel uses this for DELETE requests
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    Swal.fire("Deleted!", response.message, "success").then(() => location.reload());
                },
                error: function (xhr) {
                    Swal.fire("Error!", xhr.responseJSON.message, "error");
                }
            });
        }
    });
});


</script>


    
<script>
    $(document).ready(function () {
        $("#editGroupForm").submit(function (e) {
            e.preventDefault();

            // Simulating form submission (replace with actual AJAX request if needed)
            setTimeout(function () {
                $("#editGroupModal").modal("hide"); // Close modal after submission
            }, 500); // Delay for a smooth transition
        });
    });
</script>

@endsection
