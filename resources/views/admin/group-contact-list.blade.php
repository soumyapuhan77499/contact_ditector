@extends('layouts.app')

@section('styles')
<style>
    body {
        background: #f4f6f9;
    }

    .group-header {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .group-header h3 {
        font-weight: bold;
        margin-bottom: 10px;
    }

    .group-header p {
        margin: 0;
        font-size: 1rem;
        opacity: 0.9;
    }

    .table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }

    .table thead {
        background-color: #4e54c8;
        color: white;
    }

    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }

    .contact-icon {
        color: #4e54c8;
        margin-right: 5px;
    }

    .btn-success {
        background: linear-gradient(45deg, #28a745, #43e97b);
        border: none;
        padding: 10px 20px;
        border-radius: 30px;
        font-weight: bold;
        color: white;
    }

    .btn-success:hover {
        background: linear-gradient(45deg, #218838, #38d175);
    }

    .back-btn {
        border-radius: 25px;
    }
</style>
@endsection

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="container mt-5">
    <div class="group-header">
        <h3><i class="fa fa-users me-2"></i> Group: {{ $group->group_name }}</h3>
        <p><i class="fa fa-id-badge me-1"></i> Group ID: {{ $group->group_id }}</p>
    </div>

    @if($contacts->isEmpty())
        <div class="alert alert-warning text-center fw-bold">No contacts assigned to this group.</div>
    @else
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-header">
                    <tr>
                        <th>#</th>
                        <th><i class="fa fa-user"></i> Name</th>
                        <th><i class="fa fa-phone"></i> Phone</th>
                        <th><i class="fa fa-calendar"></i> Assigned On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contacts as $index => $contact)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $contact->contactDetails->name ?? 'N/A' }}</td>
                        <td>{{ $contact->contactDetails->phone ?? 'N/A' }}</td>
                        <td>{{ $contact->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- WhatsApp Message Button -->
        <div class="text-center mt-4">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#whatsappModal">
                <i class="fa fa-whatsapp me-1"></i> Send WhatsApp Message to Group
            </button>
        </div>

        <!-- WhatsApp Modal -->
        <div class="modal fade" id="whatsappModal" tabindex="-1" aria-labelledby="whatsappModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('sendWhatsappMessage') }}" method="POST" enctype="multipart/form-data" class="modal-content">
                    @csrf
                    <input type="hidden" name="group_id" value="{{ $group->group_id }}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="whatsappModalLabel">Send Message to Group: {{ $group->group_name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="3" placeholder="Enter your message here..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Image (optional)</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-paper-plane"></i> Send
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

   
</div>
@endsection
