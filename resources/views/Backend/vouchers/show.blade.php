@extends('Backend.layouts.app', ['title' => __('Voucher')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('voucher') }}">Discount Coupons</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        <a href="{{ route('voucher-create') }}" class="btn btn-sm btn-neutral">Add New Discount Coupons</a>
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
                        <h3 class="mb-0">Discount Coupon</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th><b>Name</b></th>
                                    <td>{{$voucher->name}}</td>
                                </tr>
                                <tr>
                                    <th><b>type</b></th>
                                    <td>{{$voucher->type}}</td>
                                </tr>
                                <tr>
                                    <th><b>order_amount</b></th>
                                    <td>{{$voucher->order_amount}}</td>
                                </tr>
                                <tr>
                                    <th><b>discount_amount</b></th>
                                    <td>{{$voucher->discount_amount}}</td>
                                </tr>
                                <tr>
                                    <th><b>starts_at</b></th>
                                    <td>{{$voucher->starts_at}}</td>
                                </tr>
                                <tr>
                                    <th><b>expires_at</b></th>
                                    <td>{{$voucher->expires_at}}</td>
                                </tr>
                                <tr>
                                    <th><b>code</b></th>
                                    <td>{{$voucher->code}}</td>
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
