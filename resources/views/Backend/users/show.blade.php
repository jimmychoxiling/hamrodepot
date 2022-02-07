@extends('Backend.layouts.app', ['title' => __('Users')])

@section('content')
<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user') }}">Users</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('user-create') }}" class="btn btn-sm btn-neutral">Add New Users</a>
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
                    <h3 class="mb-0">Users</h3>
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th><b>Name</b></th>
                                <td>{{$user->name}}</td>
                            </tr>
                            <tr>
                                <th><b>Email</b></th>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <th><b>Phone</b></th>
                                <td>{{$user->phone_number}}</td>
                            </tr>
                            <tr>
                                <th><b>Address 1</b></th>
                                <td>{{$user->address_line1}}</td>
                            </tr>
                            <tr>
                                <th><b>Address 2</b></th>
                                <td>{{$user->address_line2}}</td>
                            </tr>
                            <tr>
                                <th><b>City</b></th>
                                <td>{{$user->city}}</td>
                            </tr>
                            <tr>
                                <th><b>Zipcode</b></th>
                                <td>{{$user->zipcode}}</td>
                            </tr>
                            <tr>
                                <th><b>State</b></th>
                                <td>{{$user->state}}</td>
                            </tr>
                            <tr>
                                <th><b>Date of Birth</b></th>
                                <td>@if(!empty($user->birth_date)){{$user->birth_date}}@endif</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @foreach($user->address as $address)
                <div class="card-header border-0">
                    <h3 class="mb-0">{{$address->delivery_type == 1 ? 'Shipping': 'Billing' }} Address</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                                <th><b>Name</b></th>
                                <td>{{$address->name}} {{$address->last_name}}</td>
                            </tr>
                            <tr>
                                <th><b>Phone</b></th>
                                <td>{{$address->phone_number}}</td>
                            </tr>
                            <tr>
                                <th><b>Address Type</b></th>
                                <td>{{$address->address_type == 1 ? 'Home': 'Office' }}</td>
                            </tr>
                            <tr>
                                <th><b>Address 1</b></th>
                                <td>{{$address->address_line1}}</td>
                            </tr>
                            <tr>
                                <th><b>Address 2</b></th>
                                <td>{{$address->address_line2}}</td>
                            </tr>
                            <tr>
                                <th><b>City</b></th>
                                <td>{{$address->city}}</td>
                            </tr>
                            <tr>
                                <th><b>Zipcode</b></th>
                                <td>{{$address->zipcode}}</td>
                            </tr>
                            <tr>
                                <th><b>State</b></th>
                                <td>{{$address->state}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('Backend.layouts.footers.auth')
</div>
@endsection

@section('extra-js')

@endsection