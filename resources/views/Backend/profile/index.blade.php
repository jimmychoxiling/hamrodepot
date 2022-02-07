@extends('Backend.layouts.app', ['title' => __('User Profile')])

@section('content')
<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--7">
@role('Admin')
@include('Backend.profile.edit')
@endrole
@role('Seller')
@include('Seller.profile.edit')
@endrole
@include('Backend.layouts.footers.auth')
</div>
@endsection