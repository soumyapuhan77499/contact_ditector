@extends('layouts.app')

@section('styles')
<!-- Add Bootstrap and Custom Styles -->

<style>
body {
    min-height: 100vh;
}

/* Accordion Styling */
.accordion-button {
    background: linear-gradient(90deg, #4B79A1, #283E51) !important;
    color: white !important;
    font-weight: bold;
    border-radius: 10px !important;
    transition: 0.3s ease-in-out;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(90deg, #5271C4, #243B55) !important;
    transform: scale(1.02);
}

.accordion-item {
    border: none;
    background: transparent;
}

/* Group Header */
.group-header {
    font-size: 15px;
    padding: 15px;
}

.group-name {
    color: rgb(251, 250, 243);
}

/* Group Badge */
.group-badge {
    background: rgb(247, 243, 205);
    color: rgb(7, 7, 7);
    font-size: 14px;
    padding: 5px 10px;
    border-radius: 20px;
}

/* Table Styling */
.table {
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.table-header {
    background: linear-gradient(90deg, #5271C4, #243B55);
    color: white;
}

.table th,
.table td {
    vertical-align: middle;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* Buttons */
.btn-custom {
    background: linear-gradient(90deg, #FFC371, #FF5F6D);
    border: none;
    color: white;
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
}

.btn-custom:hover {
    background: linear-gradient(90deg, #FF5F6D, #FFC371);
    transform: scale(1.05);
}

.btn-success {
    background-color: #28a745;
    border-color: #28a745;
    font-weight: bold;
    transition: all 0.3s ease-in-out;
}

.btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>

@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Manage Assigned Groups</h2>
        <a href="{{ route('admin.assignGroup') }}" class="btn btn-custom">
            <i class="fa fa-plus"></i> Assign Group
        </a>
    </div>

    @if($groupedContacts->isEmpty())
    <div class="alert alert-warning text-center fw-bold">No assigned groups available.</div>
    @else
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="accordion" id="groupAccordion">
        @foreach ($groupedContacts as $groupId => $contacts)
        <div class="accordion-item">
            <h2 class="accordion-header" id="heading{{ $groupId }}">
                <button class="accordion-button collapsed group-header" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse{{ $groupId }}" aria-expanded="false"
                    aria-controls="collapse{{ $groupId }}">
                    <span class="me-2">📌 <b>Group Name:</b> <span
                            class="group-name">{{ $contacts->first()->group->group_name ?? 'N/A' }}</span></span>
                    <span class="badge group-badge">
                        <i class="fa fa-phone me-1"></i> {{ count($contacts) }} Contacts
                    </span>
                </button>
            </h2>

        

            <div id="collapse{{ $groupId }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $groupId }}"
                data-bs-parent="#groupAccordion">
                <div class="accordion-body">
                    <table class="table table-hover">
                        <thead class="table-header">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Assigned On</th>
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

                    <!-- Button to trigger WhatsApp message modal for this group -->
                    <div class="mt-4 d-flex justify-content-center">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#whatsappModal{{ $groupId }}">
                            <i class="fa fa-send"></i> Send WhatsApp Message
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for sending WhatsApp message to this group -->
        <div class="modal fade" id="whatsappModal{{ $groupId }}" tabindex="-1"
            aria-labelledby="whatsappModalLabel{{ $groupId }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="whatsappModalLabel{{ $groupId }}">Send WhatsApp Message to Group
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="whatsappMessageForm{{ $groupId }}" action="{{ route('sendWhatsappMessage') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                            <input type="hidden" name="group_id" value="{{ $groupId }}">
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" name="message" rows="3"
                                    placeholder="Enter your message"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Photo (Optional)</label>
                                <input class="form-control" type="file" id="image" name="image">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection


@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Ensure the first accordion item is open by default
    let firstAccordion = document.querySelector('.accordion-button');
    if (firstAccordion) {
        firstAccordion.click();
    }
});
</script>
@endsection