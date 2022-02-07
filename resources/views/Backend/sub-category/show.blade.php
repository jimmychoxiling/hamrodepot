@extends('Backend.layouts.app', ['title' => __('Sub-Category')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('sub-category') }}">Sub-Category</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('sub-category-create') }}" class="btn btn-sm btn-neutral">Add New Category</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Sub-Category</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th><b>Name</b></th>
                                    <td>{{$subCategory->name}}</td>
                                </tr>
                                <tr>
                                    <th><b>Description</b></th>
                                    <td>{{$subCategory->description}}</td>
                                </tr>
                                <tr>
                                    <th><b>Image</b></th>
                                    <td>
                                    @if(!empty($subCategory->image) && \Illuminate\Support\Facades\Storage::exists($subCategory->image))
                                        <img src="{{ url('storage') . '/' .  $subCategory->image}}"
                                             style="height: 150px;">
                                    @else
                                        <img src="{{ url('storage/no_image.png')}}" style="height: 150px;">
                                    @endif
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('Backend.layouts.footers.auth')
    </div>
@endsection

@section('extra-js')

@endsection
