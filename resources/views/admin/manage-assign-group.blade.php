@extends('layouts.app')
@section('styles')
    <style>
        body {
            background: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: linear-gradient(to bottom right, #ffffff, #f0f0f0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #333;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4e54c8, #8f94fb);
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: bold;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #4349b8, #7f85f0);
        }

        .card-icon {
            font-size: 2rem;
            color: #4e54c8;
            margin-bottom: 10px;
        }

        .section-header {
            color: #2d2f31;
        }

        .btn-custom {
            background-color: #20c997;
            color: white;
            border-radius: 25px;
            font-weight: 500;
            padding: 10px 20px;
        }

        .btn-custom:hover {
            background-color: #17a589;
            color: white;
        }
    </style>
@endsection


@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class=" text-dark">Manage Assigned Groups</h4>
            <a class="btn btn-info" href="{{ route('admin.assignGroup') }}" class="btn btn-custom">
                <i class="fa fa-plus"></i> Assign Group
            </a>
        </div>

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

        @if ($groupedContacts->isEmpty())
            <div class="alert alert-warning text-center">No assigned groups available.</div>
        @else
            <div class="row">
                @foreach ($groupedContacts as $groupId => $contacts)
                    @php
                        $groupName = $contacts->first()->group->group_name ?? 'N/A';
                        $contactCount = count($contacts);
                    @endphp

                    <div class="col-md-4 mb-4">
                        <div class="card shadow-sm h-100 border-0 group-card">
                            <div class="card-body text-center py-4 px-3">
                                <div class="group-icon mb-3 mx-auto">
                                    <i class="fa fa-users fa-2x"></i>
                                </div>
                                <h5 class="card-title mb-2 text-dark">{{ $groupName }}</h5>
                                <p class="card-text text-muted mb-4">
                                    <i class="fa fa-phone me-1 text-primary"></i>
                                    {{ $contactCount }} Contact{{ $contactCount > 1 ? 's' : '' }}
                                </p>
                                <a href="{{ url('admin/group/contacts/' . $groupId) }}"
                                class="btn btn-primary rounded-pill px-4">
                                View Contacts
                             </a>
                             
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
            // Your custom JS here (if needed)
        });
    </script>
@endsection
