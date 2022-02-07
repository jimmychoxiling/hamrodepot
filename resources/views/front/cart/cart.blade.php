@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<div id="content" class="main-content">
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="{{ url('/') }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a>
                            </li>
                            <li>My Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="my_cart_wrapper card_section">
        <div class="container">
            <div class="row">
                <div class="col col-9">
                    <div class="card my_cart_card">
                        <div class="card_title">
                            <h2>My Cart</h2>
                        </div>
                        @if (count($cart))
                        <div class="my_cart_item_wrap">
                            @foreach($cart as $item)
                            <div class="my_cart_item">
                                <div class="my_cart_product_img">
                                    <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}" class="image">
                                        @if(!empty($item->products->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($item->products->productsImagesFirst->filename))
                                        <img src="{{ url('storage') . '/' . $item->products->productsImagesFirst->filename}}">
                                        @else
                                        <img src="{{ url('storage') . '/no_image.png'}}">
                                        @endif
                                    </a>
                                </div>
                                <div class="my_cart_product_desc">
                                    <p>
                                        <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}">{{ $item->products->name }}</a>
                                    </p>
                                    <ul>
                                        <li><label for="">Seller :</label> <span><a href="javascript:;">{{ $item->products->user->name }} {{ $item->products->user->last_name }}</a></span>
                                        </li>
                                        <li><label for="">Purchase Type
                                                :</label><span>{{ $item->options->extra_detail['product_type'] }}</span>
                                        </li>
                                        @if($item->options->extra_detail['product_type'] == 'Rent')
                                        <li><label for="">Selected Date :</label>
                                            <span>{{ date('m-d-Y',strtotime($item->options->extra_detail['from_date'])) }} {{ date('H:i',strtotime( $item->options->extra_detail['from_time'])) }} to {{ date('m-d-Y',strtotime($item->options->extra_detail['to_date'])) }} {{ date('H:i',strtotime( $item->options->extra_detail['to_time'])) }} </span>
                                        </li>
                                        <li><label for="">Total Hours :</label><span>{{ $item->options->extra_detail['total_hrs'] }} hr</span>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="my_cart_quantity">
                                    <div class="sg_product_quantity">
                                        <span class="counter-btn minusCart" data-id="{{$item->rowId}}" data-proid="{{$item->id}}"><i class="fa fa-minus"></i></span>
                                        <input type="number" class="output" name="" data-id="{{$item->rowId}}" data-proid="{{$item->id}}" id="X" value="{{ $item->qty }}">
                                        <!-- <div class="output" id="output"
                                                         contenteditable="">{{ $item->qty }}</div> -->
                                        <span class="counter-btn plusCart" data-id="{{$item->rowId}}" data-proid="{{$item->id}}"><i class="fa fa-plus"></i></span>
                                    </div>
                                </div>
                                <div class="my_cart_item_action">
                                    <ul>
                                        <li><a href="javascript:;" data-tooltip="Remove" class="remove-from-cart" data-proid="{{$item->id}}" data-id="{{$item->rowId}}"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
                                    </ul>
                                </div>
                                <div class="my_cart_item_price">
                                    <h4>{{ config('constant.CURRENCY_SIGN') }}{{$item->price}}</h4>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="my_cart_place_btn btn">
                            <a href="{{route('checkout')}}">Checkout </a>
                        </div>
                        @else
                        <div class="no_data_error">
                            <div class="no_data_inner">
                                <div class="no_data_image">
                                    <svg id="b21613c9-2bf0-4d37-bef0-3b193d34fc5d" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" width="647.63626" height="632.17383" viewBox="0 0 647.63626 632.17383">
                                        <path d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z" transform="translate(-276.18187 -133.91309)" fill="#f2f2f2" />
                                        <path d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z" transform="translate(-276.18187 -133.91309)" fill="#3bba9c" />
                                        <path d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z" transform="translate(-276.18187 -133.91309)" fill="#3bba9c" />
                                        <circle cx="190.15351" cy="24.95465" r="20" fill="#3bba9c" />
                                        <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff" />
                                        <path d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z" transform="translate(-276.18187 -133.91309)" fill="#e6e6e6" />
                                        <path d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z" transform="translate(-276.18187 -133.91309)" fill="#3bba9c" />
                                        <path d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z" transform="translate(-276.18187 -133.91309)" fill="#3bba9c" />
                                        <circle cx="433.63626" cy="105.17383" r="20" fill="#3bba9c" />
                                        <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff" />
                                    </svg>
                                </div>
                                <h2>Forgot to add your items?</h2>
                                <br>
                                <form action="{{route('search')}}" method="get">
                                    <input type="hidden" name="cat" value="">
                                    <input type="hidden" name="search" value="all">
                                    <div class="btn">
                                        <button type="submit"  class="shop-now-btn" >Shop Now</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col col-3">
                    <div class="card my_cart_card">
                        <div class="card_title">
                            <h2>Price Details</h2>
                        </div>

                                <li><label for="" id="cartCount">Product Price ({{ Cart::count() }} items)</label>
                                    <span id="subtotal">
                                    {{ config('constant.CURRENCY_SIGN') }}{{ Cart::subtotal() }}</span>
                                </li>
                            </ul>
                            <div class="my_cart_total_ammount">
                                <label for="">Total Amount</label>
                                <label id="total">{{ config('constant.CURRENCY_SIGN') }}{{ Cart::total() }}@if(Cart::discountFloat()>0)
                                <sup> * Offer applied</sup>
                                @endif</label>
                            </div>
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
<script type="text/javascript">
    var cartRemove = "{{route('cart-remove')}}";
    var cartUpdate = "{{route('cart-update')}}";

    
    $('#apply_offer').click(function(e) {
        let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        let offer_code = $("input[name=offer_code]").val();
        let cart_total = '{{Cart::total()}}';
        cart_total = cart_total.replace(/,/g, "");
    $.ajax({
        type: "POST",
        url: "{{route('cart-offer-apply')}}",
        data: { _token: CSRF_TOKEN, cart_total:cart_total,offer_code:offer_code},
        success: function(result) {
                let final = parseFloat(cart_total) - parseFloat(result);
            $( ".my_cart_price_overview" ).append('<div class="my_cart_total_ammount"><label for="">Offer Apply Amount</label><label id="total"> $'+final+'.00</label><button id="cancel_offer" type="button" title="Close">X</button><div class="offer_applied"></div></div>');
        },
        error: function(result) {
            alert('error');
        }
    });
  //$('#apply_offer').prop('disabled', true);
    });
    $("#check_offer").click(function(e){
        let total = $(this).attr('data-total');
        
        // let total = $('#total').text('$' + data.total);
        //alert(parseFloat(total));
    });
    $("body").on("click", "#cancel_offer", function(){
        $.ajax({
        type: "GET",
        url: "{{route('cart-offer-cancel')}}",
        data: { },
        success: function(result) {
              console.log("dg");
        },
        error: function(result) {
            alert('error');
        }
    });
});
</script>
@endsection
