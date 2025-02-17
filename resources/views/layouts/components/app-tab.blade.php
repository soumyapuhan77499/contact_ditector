<ul class="nav nav-tabs flex-column flex-sm-row mt-2" role="tablist">

    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="{{ route('admin.pratihariProfile') }}" role="tab" aria-controls="profile" aria-selected="true">
            <i class="fas fa-users"></i> Profile
        </a>
    </li>
    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="family-tab" data-toggle="tab" href="{{ route('admin.pratihariFamily') }}" role="tab" aria-controls="family" aria-selected="true">
            <i class="fas fa-users"></i> Family
        </a>
    </li>
    
    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="id-card-tab" data-toggle="tab" href="{{ route('admin.pratihariIdcard') }}" role="tab" aria-controls="id-card" aria-selected="false">
            <i class="fas fa-id-card"></i> ID Card
        </a>
    </li>
    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="address-tab" data-toggle="tab" href="{{ route('admin.pratihariAddress') }}" role="tab" aria-controls="address" aria-selected="false">
            <i class="fas fa-map-marker-alt"></i> Address
        </a>
    </li>
    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="occupation-tab" data-toggle="tab" href="{{ route('admin.pratihariOccupation') }}" role="tab" aria-controls="occupation" aria-selected="false">
            <i class="fas fa-briefcase"></i> Occupation
        </a>
    </li>

    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="seba-details-tab" data-toggle="tab" href="{{ route('seba-details') }}" role="tab" aria-controls="seba-details" aria-selected="false">
            <i class="fas fa-cogs"></i> Seba
        </a>
    </li>

    <li class="nav-item col-12 col-sm-auto">
        <a class="nav-link" id="social-media-tab" data-toggle="tab" href="{{ route('social-media') }}" role="tab" aria-controls="social-media" aria-selected="false">
            <i class="fas fa-share-alt" style="margin-right: 2px"></i>Social Media 
        </a>
    </li>
   
</ul>
