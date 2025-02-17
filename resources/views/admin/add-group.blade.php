@extends('layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="left-content">
            <span class="main-content-title mg-b-0 mg-b-lg-1">ADD GROUP</span>
        </div>
        <div class="justify-content-center mt-2">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Group</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Group</li>
            </ol>
        </div>
    </div>
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                confirmButtonColor: '#d33'
            });
        </script>
    @endif
    <!-- Group Form -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.saveGroup') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="group_name">Group Name</label>
                    <input type="text" class="form-control" id="group_name" name="group_name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Save Group</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
  
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection