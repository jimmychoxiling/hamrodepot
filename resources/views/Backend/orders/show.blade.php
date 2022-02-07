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
                                <li class="breadcrumb-item active" aria-current="page">#{{ $order->order_no }}</li>
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
                        <h3 class="mb-0">#{{ $order->order_no }}</h3>
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
                                        {{$order->shippingAddress->address_line1}},
                                        @if($order->shippingAddress->address_line2 != '')
                                            {{$order->shippingAddress->address_line2}},
                                        @endif
                                        {{$order->shippingAddress->city}},
                                        {{ $order->shippingAddress->state }},
                                        {{ $order->shippingAddress->country->name }}
                                        - {{ $order->shippingAddress->zipcode }}<br/>

                                        <b>Phone: </b>{{$order->user->phone_number}}<br/>
                                        <b>Email: </b> {{$order->user->email}}
                                    </address>
                                </div>
                                <div class="col-sm-4 invoice-col">
                                </div>

                                <div class="col-sm-4 invoice-col">
                                    <b>Order No.</b> #{{ $order->order_no }}<br/>
                                    <b>Date:</b> {{date('m-d-Y H:i',strtotime($order->created_at))}}<br/>
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
                                        @foreach($order->orderDetail as $orderDetail)
                                            <tr>
                                                <td>
                                                    @if(!empty($orderDetail->product->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($orderDetail->product->productsImagesFirst->filename))
                                                        <img
                                                            src="{{ url('storage') . '/' . $orderDetail->product->productsImagesFirst->filename}}"
                                                            alt="{{ $orderDetail->product->name }}"
                                                            style="height: 100px;">
                                                    @else
                                                        <img src="{{ url('storage') . '/no_image.png'}}"
                                                             alt="{{ $orderDetail->product->name }}"
                                                             style="height: 100px;">
                                                    @endif

                                                </td>
                                                <td>
                                                    <h4>{{ $orderDetail->name }}</h4>
                                                    @if($orderDetail->sell_type == 'Rent')
                                                        <li><label for="">Selected Date :</label>
                                                            <span>{{ date('m-d-Y',strtotime($orderDetail->from_date)) }} {{ date('H:i',strtotime($orderDetail->from_time)) }} to {{ date('m-d-Y',strtotime($orderDetail->to_date)) }} {{ date('H:i',strtotime($orderDetail->to_time)) }}</span>
                                                        </li>
                                                        <li><label for="">Total Hours :</label><span>{{ $orderDetail->total_hrs }} hr</span>
                                                        </li>
                                                    @endif
                                                    <h5>Seller
                                                        : {{ $orderDetail->user->name }} {{ $orderDetail->user->last_name }}</h5>
                                                </td>
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->price }}</td>
                                                <td>{{ $orderDetail->quantity }}</td>
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->discount }}</td>
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->total - $orderDetail->discount }}</td>
                                                <td>
                                                    @php
                                                        $class = 'success';
                                                        if ($orderDetail->orderStatusLast->OrderStatus->id == 6) {
                                                            $class = 'danger';
                                                        }
                                                        if($orderDetail->orderStatusLast->OrderStatus->id == 1) {
                                                            $class = 'warning';
                                                        }
                                                    @endphp
                                                    <div class="status-main"><span
                                                            class="order-badge badge badge-pill badge-{{$class}}">{{$orderDetail->orderStatusLast->OrderStatus->name}}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                @php
                                                    if ($orderDetail->orders->payment_status == 'Succeeded') {
                                                        $class = 'success';
                                                    }
                                                    if($orderDetail->orders->payment_status == 'Incomplete') {
                                                        $class = 'danger';
                                                    }
                                                @endphp
                                                <div class="status-main"><span
                                                        class="order-badge badge badge-pill badge-{{$class}}">{{$orderDetail->orders->payment_status}}</span>
                                                </div>
                                            </td>
                                            </tr>
                                        @endforeach
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
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{$order->sub_total}}</td>
                                            </tr> -->


                                            <tr>
                                                <th>Grand Total </th>
                                                <td>{{ config('constant.CURRENCY_SIGN') }}{{  $orderDetail->total - $orderDetail->discount}}</td>
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
                            @foreach($order->orderDetail as $orderDetail)
                                <tr>
                                    <td>{{ $orderDetail->user->name }} {{ $orderDetail->user->last_name }}</td>
                                    <td>{{ $orderDetail->name }}</td>
                                    <td>{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->total }}</td>
                                    <td>{{ $orderDetail->commission }}%</td>
                                    <td>{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->commission_total }}</td>
                                    <td>@php($seller_amount = $orderDetail->total - $orderDetail->commission_total){{ config('constant.CURRENCY_SIGN') }}{{$seller_amount}}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td><b>Total </b></td>
                                <td></td>
                                <td><b>{{ config('constant.CURRENCY_SIGN') }}{{$order->total}}</b></td>
                                <td></td>
                                <td><b>{{ config('constant.CURRENCY_SIGN') }}{{$order->commission_total}}</b></td>
                                <td>@php($seller_amount_total = $order->total - $order->commission_total)<b>{{ config('constant.CURRENCY_SIGN') }}{{$seller_amount_total}}</b></td>
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
