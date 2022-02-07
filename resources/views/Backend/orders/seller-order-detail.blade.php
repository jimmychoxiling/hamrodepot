@extends('Backend.layouts.app', ['title' => __('Orders')])

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
                                <li class="breadcrumb-item"><a href="{{ route('order') }}">Orders</a></li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    #{{ $order->orders->order_no }}</li>
                            </ol>
                        </nav>
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
                        <h3 class="mb-0">#{{ $order->orders->order_no }}</h3>
                    </div>

                    <div class="card-body">
                        <section class="invoice">
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            @if(session()->has('failure'))
                                <div class="alert alert-danger">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×
                                    </button>
                                    {{ session()->get('failure') }}
                                </div>
                            @endif

                            <div class="row invoice-info">

                                <div class="col-sm-4 invoice-col">
                                    <strong>Ship To</strong>
                                    <address>
                                        {{$order->orders->shippingAddress->address_line1}},
                                        @if($order->orders->shippingAddress->address_line2 != '')
                                            {{$order->orders->shippingAddress->address_line2}},
                                        @endif
                                        {{$order->orders->shippingAddress->city}},
                                        {{ $order->orders->shippingAddress->state }},
                                        {{ $order->orders->shippingAddress->country->name }}
                                        - {{ $order->orders->shippingAddress->zipcode }}<br/>

                                        <b>Phone: </b>{{$order->orders->user->phone_number}}<br/>
                                        <b>Email: </b> {{$order->orders->user->email}}
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <b>Order No.</b> #{{ $order->orders->order_no }}<br/>
                                    <b>Date:</b> {{date('m-d-Y H:i',strtotime($order->orders->created_at))}}<br/>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Details</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Discount</th>
                                            <th>Sub Total</th>
                                            <th>Order Status</th>
                                            <th>Payment Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td>
                                                @if(!empty($order->product->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($order->product->productsImagesFirst->filename))
                                                    <img
                                                        src="{{ url('storage') . '/' . $order->product->productsImagesFirst->filename}}"
                                                        alt="{{ $order->product->name }}" style="height: 100px;">
                                                @else
                                                    <img src="{{ url('storage') . '/no_image.png'}}"
                                                         alt="{{ $order->product->name }}" style="height: 100px;">
                                                @endif

                                            </td>
                                            <td>
                                                <h4>{{ $order->name }}</h4>
                                                @if($order->sell_type == 'Rent')
                                                    <li><label for="">Selected Date :</label>
                                                        <span>{{ date('m-d-Y',strtotime($order->from_date)) }} {{ date('H:i',strtotime($order->from_time)) }} to {{ date('m-d-Y',strtotime($order->to_date)) }} {{ date('H:i',strtotime($order->to_time)) }}</span>
                                                    </li>
                                                    <li><label for="">Total Hours :</label><span>{{ $order->total_hrs }} hr</span>
                                                    </li>
                                                @endif
                                                {{--                                                    <h5>Seller : {{ $order->user->name }} {{ $order->user->last_name }}</h5>--}}
                                            </td>
                                            <td>{{ config('constant.CURRENCY_SIGN') }}{{ $order->price }}</td>
                                            <td>{{ $order->quantity }}</td>
                                            <td>{{ config('constant.CURRENCY_SIGN') }}{{ $order->discount }}</td>
                                            <td>{{ config('constant.CURRENCY_SIGN') }}{{ $order->total -$order->discount  }} </td>
                                            <td>
                                                @php
                                                    $class = 'success';
                                                    if ($order->orderStatusLast->OrderStatus->id == 6) {
                                                        $class = 'danger';
                                                    }
                                                    if($order->orderStatusLast->OrderStatus->id == 1) {
                                                        $class = 'warning';
                                                    }
                                                @endphp
                                                <div class="status-main"><span
                                                        class="order-badge badge badge-pill badge-{{$class}}">{{$order->orderStatusLast->OrderStatus->name}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @php
                                                    if ($order->orders->payment_status == 'Succeeded') {
                                                        $class = 'success';
                                                    }
                                                    if($order->orders->payment_status == 'Incomplete') {
                                                        $class = 'danger';
                                                    }
                                                @endphp
                                                <div class="status-main"><span
                                                        class="order-badge badge badge-pill badge-{{$class}}">{{$order->orders->payment_status}}</span>
                                                </div>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">

                                </div>
                                <div class="col-sm-4">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <!-- <tr>
                                                <th style="width:50%">Sub Total</th>
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{$order->sub_total -$order->discount}}</td>
                                            </tr> -->


                                            <tr>
                                                <th>Grand Total</th>
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{$order->total - $order->discount}} .00</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <hr/>
                        <h2 style="margin-top: 15px;">Commission Information</h2>
                        <hr/>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th><b>Seller</b></th>
                                <th><b>Product</b></th>
                                <th><b>Total Amount</b></th>
                                <th><b>Commission(%)</b></th>
                                <th><b>Commission Amount (Admin)</b></th>
                                <th><b>Seller Amount</b></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $order->user->name }} {{ $order->user->last_name }}</td>
                                <td>{{ $order->name }}</td>
                                <td>{{ config('constant.CURRENCY_SIGN') }}{{ $order->total }}</td>
                                <td>{{ $order->commission }}%</td>
                                <td>{{ config('constant.CURRENCY_SIGN') }}{{ $order->commission_total }}</td>
                                <td>@php($seller_amount = $order->total - $order->commission_total)
                                {{ config('constant.CURRENCY_SIGN') }}{{$seller_amount}}</td>
                            </tr>
                            <tr>
                                <td><b>Total</b></td>
                                <td></td>
                                <td><b>{{ config('constant.CURRENCY_SIGN') }}{{$order->total}}</b></td>
                                <td></td>
                                <td><b>{{ config('constant.CURRENCY_SIGN') }}{{$order->commission_total}}</b></td>
                                <td>@php($seller_amount_total = $order->total - $order->commission_total)
                                    <b>{{ config('constant.CURRENCY_SIGN') }}{{$seller_amount_total}}</b></td>
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
