@extends('Backend.layouts.app', ['title' => __('Service')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('service-request') }}">Service Requests</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        
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
                        <h3 class="mb-0">Service</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th><b>Name</b></th>
                                    <td>{{ $service->service->name }}</td>
                                </tr>
                                <tr>
                                    <th><b>Need Service On</b></th>
                                    <td>{{ $service->service_date }}</td>
                                </tr>
                                <tr>
                                    <th><b>Budget</b></th>
                                    <td>{{ config('constant.CURRENCY_SIGN') }}{{ $service->budget }}</td>
                                </tr>
                                </tr>
                                <tr>
                                    <th><b>Seller</b></th>
                                    <td>{{ $service->service->seller->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Request User</b></th>
                                    <td>{{ $service->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Email</b></th>
                                    <td>{{ $service->email ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Phone</b></th>
                                    <td>{{ $service->phone ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Category</b></th>
                                    <td>{{ $service->service->category->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Tag</b></th>
                                    <td>{{ $service->tag ? ucFirst($service->tag) : '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Time</b></th>
                                    <td>
                                        @php
                                            $serviceTime = "";
                                                foreach ($service->time as $key => $time) {
                                                    $serviceTime.= config('constant.SERVICE_TIMING')[$time];
                                                    if(count($service->time) > 1 && $key < array_key_last($service->time)){
                                                        $serviceTime.= ", ";
                                                    }
                                                }
                                        @endphp
                                        {{ $serviceTime }}
                                    </td>
                                </tr>
                                <tr>
                                    <th><b>Address</b></th>
                                    <td>{{ $service->address }}</td>
                                </tr>
                                <tr>
                                    <th><b>State</b></th>
                                    <td>{{ $service->state }}</td>
                                </tr>
                                <tr>
                                    <th><b>City</b></th>
                                    <td>{{ $service->city }}</td>
                                </tr>
                                <tr>
                                    <th><b>Zipcode</b></th>
                                    <td>{{ $service->zipcode }}</td>
                                </tr>
                                <tr>
                                    <th><b>Description</b></th>
                                    <td style="white-space: normal;">{!! $service->description !!}</td>
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
