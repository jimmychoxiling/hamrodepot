@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<div id="content" class="main-content" id="detail-section">
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="{{ url('.') }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a>
                            </li>
                            <li><a href="{{ url('orders') }}">Orders</a></li>
                            <li>#{{$order->order_no}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="order_details_sec card_section">
        <div class="container">
            <div class="row">
                <div class="col col-9" >
                    <div class="card order_details_wrap">
                        <div class="card_title">
                            <h2>Order #{{$order->order_no}}</h2>
                            <span class="card_title__action"><i class="fa fa-calendar"></i> {{ date('m-d-Y',strtotime($order->created_at)) }}</span>
                        </div>
                        <div class="order_details_inner">
                            <div class="od_list_headings">
                                <div class="od_product_image">
                                    <label for="">Product</label>
                                </div>
                                <div class="od_product_desc">
                                    <label for="">Details</label>
                                </div>
                                <div class="od_product_price">
                                    <label for="">Price</label>
                                </div>
                                <div class="od_product_quantity">
                                    <label for="">Quantity</label>
                                </div>
                                <div class="od_product_sub_total">
                                    <label for="">Sub Total</label>
                                </div>
                                <div class="od_product_status">
                                    <label for="">Status</label>
                                </div>
                                <div class="od_product_view_status">
                                    <label for="">View Status</label>
                                </div>
                            </div>
                            @foreach($order->orderDetail as $orderDetail)
                            <div class="od_list_item">
                                <div class="od_product_image">
                                    @if(!empty($orderDetail->product->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($orderDetail->product->productsImagesFirst->filename))
                                    <img src="{{ url('storage') . '/' . $orderDetail->product->productsImagesFirst->filename}}" alt="{{ $orderDetail->product->name }}">
                                    @else
                                    <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $orderDetail->product->name }}">
                                    @endif
                                </div>
                                <div class="od_product_desc">
                                    <h5>
                                        <a href="{{ route('product-detail', array('slug2' => $orderDetail->product->category->slug, 'slug3' => $orderDetail->product->sub_category->slug, 'slug4' => $orderDetail->product->slug)) }}">{{ $orderDetail->name }}</a>
                                    </h5>
                                    @if($orderDetail->sell_type == 'Rent')
                                    <div class="my_cart_product_desc">
                                        <ul>
                                            <li><label for="">Purchase Type :</label><span>Rent</span></li>
                                            <li><label for="">Selected Date :</label>
                                                <span>{{ date('m-d-Y',strtotime($orderDetail->from_date)) }} {{ date('H:i',strtotime($orderDetail->from_time)) }} to {{ date('m-d-Y',strtotime($orderDetail->to_date)) }} {{ date('H:i',strtotime($orderDetail->to_time)) }}</span>
                                            </li>
                                            <li><label for="">Total Hours :</label><span>{{ $orderDetail->total_hrs }} hr</span>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </div>
                                <div class="od_product_price">
                                    <span data-text="Price">{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->price }}</span>
                                </div>
                                <div class="od_product_quantity">
                                    <span data-text="Quantity">{{ $orderDetail->quantity }}</span>
                                </div>
                                <div class="od_product_sub_total">
                                    <span data-text="Sub Total">{{ config('constant.CURRENCY_SIGN') }}{{ $orderDetail->total }}</span>
                                </div>
                                <div class="od_product_status">
                                    @php
                                    if($orderDetail->orderStatusLast->OrderStatus->name == 'Pending'){ $status = 'pending'; }
                                    if($orderDetail->orderStatusLast->OrderStatus->name == 'Confirm'){ $status = 'confirm'; }
                                    if($orderDetail->orderStatusLast->OrderStatus->name == 'Processing'){ $status = 'confirm'; }
                                    if($orderDetail->orderStatusLast->OrderStatus->name == 'Dispatched'){ $status = 'confirm'; }
                                    if($orderDetail->orderStatusLast->OrderStatus->name == 'Completed'){ $status = 'confirm'; }
                                    if($orderDetail->orderStatusLast->OrderStatus->name == 'Cancel'){ $status = 'cancelled'; }
                                    @endphp
                                    <span data-text="Status" ><span class="{{ $status }} status_span" id="detail_status_{{ $orderDetail->id}}">{{ $orderDetail->orderStatusLast->OrderStatus->name }}</span></span>
                                </div>
                                <div class="od_product_view_status">
                                    <a href="#!"><i class="fa fa-truck"></i></a>
                                </div>

                                @if($orderDetail->orderStatusLast->OrderStatus->id < 5) <div class="od_product_cancel_btn" id="od_product_cancel_btn_{{$orderDetail->id}}">
                                    <a href="javascript:void(0);" data-href="{{route('order-cancel', ['id' => $orderDetail->id])}}" class="od_product_cancel"><i class="fa fa-close"></i></a>
                            </div>
                            @endif
                            <div class="od_status_box_wrap card" id="2">
                                <div class="sg_purchase_close_btn">
                                    <i class="fa fa-times" aria-hidden="true"></i>
                                </div>
                                <ul class="od_status_box"  id="status_history_{{$orderDetail->id}}">
                                    @foreach($orderDetail->orderStatusHistory as $orderStatusHistory_val)
                                    <li class="@if($orderStatusHistory_val->OrderStatus->id == '5' || $orderStatusHistory_val->OrderStatus->id == '6') complete @elseif($loop->last) current @else complete @endif">
                                        <label for="">{{$orderStatusHistory_val->OrderStatus->name}}
                                            :</label>
                                        <span>{{ date('m-d-Y H:i', strtotime($orderStatusHistory_val->created_at)) }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="od_total_price_wrap">
                        <div class="od_price_title">
                            <h4>Totals</h4>
                        </div>
                        <div class="od_total_price_details">
                            <ul>
                                <li><label for="">Sub Total :</label><span>{{ config('constant.CURRENCY_SIGN') }}{{$order->sub_total}}</span></li>
                                <li><label for="">Total</label> <span>{{ config('constant.CURRENCY_SIGN') }}{{$order->total}}</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col col-3">
                <div class="card order_details_payment">
                    <div class="card_title">
                        <h2>Payment Info</h2>
                    </div>
                    <div class="od_payment_inner">
                        <ul>
                            <li><label for="">Payment Method</label> <span class="">{{$order->payment_method}}</span></li>
                        </ul>
                    </div>
                    <div class="od_payment_inner">
                        <ul>
                            <li><label for="">Payment Sataus</label>
                             @if($order->payment_status == 'Succeeded')
                             <span class="status_span confirm">Paid</span>
                            @else
                            <span class="status_span cancelled">Unpaid</span>
                            @endif
                            </li>
                        </ul>
                    </div>
                    <div class="card_title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="od_address_inner">
                        <p>
                            {{$order->shippingAddress->address_line1}},
                            @if($order->shippingAddress->address_line2 != '')
                            {{$order->shippingAddress->address_line2}},
                            @endif
                            {{$order->shippingAddress->city}},
                            {{ $order->shippingAddress->state }},
                            {{ $order->shippingAddress->country->name }}
                            - {{ $order->shippingAddress->zipcode }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>
@include('front.layouts.app-footer')
@endsection
@section('extra-js')
<script>
    $(document).on('click', '.od_product_cancel', function() {
        var href = $(this).data('href');
        var that = $(this);
        swal({
                title: "",
                text: "Are you sure? Cancel this Order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, cancel it!",
                closeOnConfirm: true
            },
            function(confirm) {
                if (confirm) {
                    $('.order_details_sec').addClass('section-loader');
                    cancelOrder(href, that[0]);
                }
            });
    });

    function cancelOrder(url, ele) {
        $.ajax({
            type: "get",
            url: url,
            success: function(data) {
                if(data.html && data.success) {
                    $('#detail_status_' + data.detail.id).removeClass('pending confirm').addClass('cancelled');
                    $('#detail_status_' + data.detail.id).text('Cancel');
                    $('#status_history_'+ data.detail.id).html(data.html);
                    $('#od_product_cancel_btn_' + data.detail.id).hide();
                    $.notifyBar({ cssClass: "success", html: data.message });
                } else {
                    $.notifyBar({ cssClass: "error", html: data.message });
                }
                $('.order_details_sec').removeClass('section-loader');

            }
        });
    }
</script>
@endsection