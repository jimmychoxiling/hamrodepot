@extends('Backend.layouts.app', ['title' => __('Seller')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('seller') }}">Seller</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('seller-create') }}" class="btn btn-sm btn-neutral">Add New Seller</a>
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
                        <h3 class="mb-0">Seller</h3>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th><b>First Name</b></th>
                                <td>{{$seller->name}}</td>
                            </tr>
                            <tr>
                                <th><b>Last Name</b></th>
                                <td>{{$seller->last_name}}</td>
                            </tr>
                            <tr>
                                <th><b>Gender</b></th>
                                <td>{{$seller->gender}}</td>
                            </tr>
                            <tr>
                                <th><b>Email</b></th>
                                <td>{{$seller->email}}</td>
                            </tr>
                             <tr>
                                <th><b>Phone</b></th>
                                <td>{{$seller->phone_number}}</td>
                            </tr>
                            <tr>
                                <th><b>Address 1</b></th>
                                <td>{{$seller->address_line1}}</td>
                            </tr>
                            <tr>
                                <th><b>Address 2</b></th>
                                <td>{{$seller->address_line2}}</td>
                            </tr>
                            <tr>
                                <th><b>City</b></th>
                                <td>{{$seller->city}}</td>
                            </tr>
                            <tr>
                                <th><b>Zipcode</b></th>
                                <td>{{$seller->zipcode}}</td>
                            </tr>
                            <tr>
                                <th><b>Country</b></th>
                                <td>@if(!empty($seller->country)){{$seller->country->name}}@endif</td>
                            </tr>
                            <tr>
                                <th><b>State</b></th>
                                <td>{{$seller->state}}</td>
                            </tr>
                          <!--  <tr>
                                <th><b>Image</b></th>
                                <td>
                                    @if(!empty($seller->image) && \Illuminate\Support\Facades\Storage::exists($seller->image))
                                        <img src="{{ url('storage') . '/' .  $seller->image}}"
                                             style="height: 150px;">
                                    @else
                                        <img src="{{ url('storage/no_image.png')}}" style="height: 150px;">
                                    @endif

                                </td>
                            </tr> -->
                            <tr>
                                <th><b>Business Name</b></th>
                                <td>{{$seller->business_name}}</td>
                            </tr>

                            <tr>
                                <th><b>Product Plan</b></th>
                                <td>{{$seller->product_plan_to_list}}</td>
                            </tr>

                            <tr>
                                <th><b>Shipping Method</b></th>
                                <td>{{$seller->shipping_method}}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

        @include('Backend.layouts.footers.auth')
    </div>
@endsection

@section('extra-js')

@endsection
