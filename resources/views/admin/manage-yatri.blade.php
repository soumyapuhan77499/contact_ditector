@extends('layouts.app')

@section('styles')
    <link href="{{ asset('assets/plugins/datatable/css/dataTables.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatable/css/buttons.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatable/responsive.bootstrap5.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

@endsection

@section('content')
    <!-- Breadcrumb -->
    <div class="breadcrumb-header d-flex justify-content-between align-items-center">
    <div class="left-content">
        <span class="main-content-title mg-b-0 mg-b-lg-1">MANAGE YATRI</span>
    </div>

    <div class="d-flex align-items-center">
        <a href="{{ route('yatri.getYatri') }}" class="btn btn-primary me-3">
            <i class="fa fa-plus"></i> Add Yatri
        </a>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item active" aria-current="page">Manage Group</li>
        </ol>
    </div>
</div>



    <div class="container mt-4">
        <div class="contact-card">
            <div class="table-responsive export-table">
                <table id="file-datatable" class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Yatri Name</th>
                            <th>Mobile No</th>
                            <th>Whatsapp No</th>
                            <th>Email</th>
                            <th>Coming Date</th>
                            <th>Going Date</th>
                            <th>Adress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($yatriDetails as $index => $yatri)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $yatri->yatri_name }}</td>
                                <td>{{ $yatri->mobile_no }}</td>
                                <td>{{ $yatri->whatsapp_no }}</td>
                                <td>{{ $yatri->email }}</td>
                                <td>{{ $yatri->date_of_coming }}</td>
                                <td>{{ $yatri->date_of_going }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#addressModal{{ $yatri->id }}">
                                        <i class="fas fa-map-marked-alt"></i> View
                                    </button>
                                </td>
                            </tr>
            
                            <!-- Modal -->
                            <div class="modal fade" id="addressModal{{ $yatri->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $yatri->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content shadow-lg">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="modalLabel{{ $yatri->id }}">
                                                <i class="fas fa-user-circle"></i> {{ $yatri->yatri_name }}'s Address & Description
                                            </h5>
                                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p><i class="fas fa-map-marker-alt text-danger me-2"></i><strong>Landmark:</strong> {{ $yatri->landmark ?? 'N/A' }}</p>
                                            <p><i class="fas fa-city text-primary me-2"></i><strong>City/Village:</strong> {{ $yatri->city_village ?? 'N/A' }}</p>
                                            <p><i class="fas fa-map text-warning me-2"></i><strong>District:</strong> {{ $yatri->district ?? 'N/A' }}</p>
                                            <p><i class="fas fa-flag text-success me-2"></i><strong>State:</strong> {{ $yatri->state ?? 'N/A' }}</p>
                                            <p><i class="fas fa-globe text-info me-2"></i><strong>Country:</strong> {{ $yatri->country ?? 'N/A' }}</p>
                                            <hr>
                                            <p><i class="fas fa-align-left text-dark me-2"></i><strong>Description:</strong><br> {{ $yatri->description ?? 'No description provided.' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
