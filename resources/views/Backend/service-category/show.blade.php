@extends('Backend.layouts.app', ['title' => __('Service-Category')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    {{-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6>--}}
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('products-create') }}" class="btn btn-sm btn-neutral">Add New Products</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content -->


@include('Backend.layouts.footers.auth')
</div>
@endsection

@section('extra-js')

@endsection