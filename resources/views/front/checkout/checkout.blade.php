@extends('front.layouts.app')
@section('extra-css')
    <script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
    <script src="https://js.stripe.com/v3/"></script>
@endsection
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
                                <li>Checkout</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="main_checkout_sec card_section">
            <div class="container">
                <div class="row">
                    <div class="col col-9">

                            @foreach($cart as $item)
                                @if($item->products->sell_type == 'Rent')
                                       <div class="card checkout_address_card">
                            <div class="card_title">
                            <h2>Pickup Address</h2>

                            </div>
                             @foreach($shipping_address as $shipping_address_val)
                                <input type="radio" name="deliver_address" class="d-none" id="shipping_id"
                                               value="{{ $shipping_address_val->id }}"
                                               @if($shipping_address_val->default_address == '1') checked @endif>
                                        <div class="radio_wrap"></div>
                             @endforeach
                            <div class="checkout_address_wrap" >
                                <div class="checkout_address_item">
                                    <div class="checkout_address_info">
                                        <div class="checkout_address_user_name">
                                            <h4 class="checkout_user_name">{{ $item->products->user->name }} {{ $item->products->user->last_name }}</h4>
                                                        <span><i class="fa fa-truck" aria-hidden="true"></i> Pickup from this address </span>
                                        </div>
                                        <div class="checkout_address_name">
                                            <label for="">
                                                <b> Store Name :</b> {{$item->products->user->business_name}},
                                                <br><b>Address :</b> {{$item->products->user->address_line1}},
                                                @if($item->products->user->address_line2 != '')
                                                    {{$item->products->user->address_line2}},
                                                @endif
                                                {{$item->products->user->city}},
                                                {{ $item->products->user->state }},
                                                {{ $item->products->user->country->name }}
                                                - {{ $item->products->user->zipcode }}
                                            </label>
                                            <label
                                                class="checkout_user_mobile"><b>Phone Number :</b> {{ $item->products->user->phone_number }}</label>
                                        </div>
                                        <div class="checkout_address_deliver_btn">
                                            <ul>
                                                <li class="btn"><a data-fancybox="" href="javascript:;" data-src="#CheckoutAddressPopup" class="editAddress" data-id="30">Edit
                                                        Address</a></li>
                                                <li class="btn"><a href="javascript:;">Deliver to this address</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="my_cart_item_wrap">
                                @foreach($cart as $item)
                                @if($item->products->sell_type == 'Rent')
                                    <div class="my_cart_item">
                                        <div class="my_cart_product_img">
                                            <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}"
                                               class="image">
                                                @if(!empty($item->products->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($item->products->productsImagesFirst->filename))
                                                    <img
                                                        src="{{ url('storage') . '/' . $item->products->productsImagesFirst->filename}}"
                                                    >
                                                @else
                                                    <img src="{{ url('storage') . '/no_image.png'}}"
                                                    >
                                                @endif
                                            </a>
                                        </div>
                                        <div class="my_cart_product_desc">
                                            <p>
                                                <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}">{{ $item->products->name }}</a>
                                            </p>
                                            <ul>
                                                <li><label for="">Seller :</label> <span><a
                                                            href="javascript:;">{{ $item->products->user->name }} {{ $item->products->user->last_name }}</a></span>
                                                </li>
                                                <li><label for="">Purchase Type
                                                        :</label><span>{{ $item->options->extra_detail['product_type'] }}</span>
                                                </li>
                                                @if($item->options->extra_detail['product_type'] == 'Rent')
                                                    <li><label for="">Selected Date :</label>
                                                        <span>{{ date('m-d-Y',strtotime($item->options->extra_detail['from_date'])) }}  {{ date('H:i',strtotime( $item->options->extra_detail['from_time'])) }} to {{ date('m-d-Y',strtotime($item->options->extra_detail['to_date'])) }} {{ date('H:i',strtotime( $item->options->extra_detail['to_time'])) }} </span>
                                                    </li>
                                                    <li><label for="">Total Hours :</label><span>{{ $item->options->extra_detail['total_hrs'] }} hr</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="my_cart_item_price">
                                            <h4>{{ config('constant.CURRENCY_SIGN') }}{{$item->price}}</h4>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                                @else
                                        <div class="card checkout_address_card">
                            <div class="card_title">
                            <h2>Shipping Address</h2>
                                <a class="card_title__action" href="#addAddressPopup"><i class="fa fa-plus"></i> Add
                                    Address</a>
                            </div>
                            <div class="checkout_address_wrap" id="shipping-address-list">
                                @foreach($shipping_address as $shipping_address_val)
                                    <div class="checkout_address_item">
                                        <input type="radio" name="deliver_address" id="shipping_id"
                                               value="{{ $shipping_address_val->id }}"
                                               @if($shipping_address_val->default_address == '1') checked @endif>
                                        <div class="radio_wrap"></div>
                                        <div class="checkout_address_info">
                                            <div class="checkout_address_user_name">
                                                <h4 class="checkout_user_name">{{ $shipping_address_val->name }} {{ $shipping_address_val->last_name }}</h4>
                                                <label
                                                    class="checkout_user_mobile">{{ $shipping_address_val->phone_number }}</label>
                                                <a href="javascript:;" class="checkout_remove_address delete"
                                                   data-tooltip="Remove" href="javascript:void(0);"
                                                   data-href="{{route('shipping-address-delete', $shipping_address_val->id) }}"><i
                                                        class="fa fa-times" aria-hidden="true"></i></a>
                                                @if($shipping_address_val->address_type == '1')
                                                    <span><i class="fa fa-home" aria-hidden="true"></i> Home</span>
                                                @else
                                                    <span><i class="fa fa-briefcase" aria-hidden="true"></i> Work</span>
                                                @endif
                                            </div>
                                            <div class="checkout_address_name">
                                                <label for="">
                                                    {{$shipping_address_val->address_line1}},
                                                    @if($shipping_address_val->address_line2 != '')
                                                        {{$shipping_address_val->address_line2}},
                                                    @endif
                                                    {{$shipping_address_val->city}},
                                                    {{ $shipping_address_val->state }},
                                                    {{ $shipping_address_val->country->name }}
                                                    - {{ $shipping_address_val->zipcode }}
                                                </label>
                                            </div>
                                            <div class="checkout_address_deliver_btn">
                                                <ul>
                                                    <li class="btn"><a data-fancybox="" href="javascript:;"
                                                                       data-src="#CheckoutAddressPopup"
                                                                       class="editAddress"
                                                                       data-id="{{ $shipping_address_val->id }}">Edit
                                                            Address</a></li>
                                                    <li class="btn"><a href="javascript:;">Deliver to this address</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="my_cart_item_wrap">
                                @foreach($cart as $item)
                                @if($item->products->sell_type != 'Rent')
                                    <div class="my_cart_item">
                                        <div class="my_cart_product_img">
                                            <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}"
                                               class="image">
                                                @if(!empty($item->products->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($item->products->productsImagesFirst->filename))
                                                    <img
                                                        src="{{ url('storage') . '/' . $item->products->productsImagesFirst->filename}}"
                                                    >
                                                @else
                                                    <img src="{{ url('storage') . '/no_image.png'}}"
                                                    >
                                                @endif
                                            </a>
                                        </div>
                                        <div class="my_cart_product_desc">
                                            <p>
                                                <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}">{{ $item->products->name }}</a>
                                            </p>
                                            <ul>
                                                <li><label for="">Seller :</label> <span><a
                                                            href="javascript:;">{{ $item->products->user->name }} {{ $item->products->user->last_name }}</a></span>
                                                </li>
                                                <li><label for="">Purchase Type
                                                        :</label><span>{{ $item->options->extra_detail['product_type'] }}</span>
                                                </li>
                                                @if($item->options->extra_detail['product_type'] == 'Rent')
                                                    <li><label for="">Selected Date :</label>
                                                        <span>{{ date('m-d-Y',strtotime($item->options->extra_detail['from_date'])) }}  {{ date('H:i',strtotime( $item->options->extra_detail['from_time'])) }} to {{ date('m-d-Y',strtotime($item->options->extra_detail['to_date'])) }} {{ date('H:i',strtotime( $item->options->extra_detail['to_time'])) }} </span>
                                                    </li>
                                                    <li><label for="">Total Hours :</label><span>{{ $item->options->extra_detail['total_hrs'] }} hr</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="my_cart_item_price">
                                            <h4>{{ config('constant.CURRENCY_SIGN') }}{{$item->price}}</h4>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                                @endif

                            @endforeach

                        <div class="card main_add_adddresses" id="addAddressPopup">
                            <div class="card_title">
                                <h2>Add Address</h2>
                                <a class="card_title__action" href="javascript:;"><i class="fa fa-times"></i> Close</a>
                            </div>
                            <div class="add_address_inner">
                                <form action="" id="shipping_details" method="post" data-parsley-validate="">
                                    <input type="hidden" name="shipping_id" id="shipping_id" value="">

                                    <div class="form__row row">
                                        <div class="col col-6 input__filed">
                                            <label class="input__label">First Name</label>
                                            <input type="text" name="name" id="name" class="form-control" required="">
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="col col-6 input__filed">
                                            <label class="input__label">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                   required="">
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-2">
                                            <label class="input__label">Phone Number</label>
                                            <select name="phone_number_type" id="phone_number_type" class="form-control"
                                                    required>
                                                <option value="Mobile">Mobile</option>
                                                <option value="Home">Home</option>
                                                <option value="Business">Business</option>
                                            </select>
                                        </div>
                                        <div class="input__filed col col-4">
                                            <label class="input__label">Phone Number</label>
                                            <input type="tel" id="phone_number" class="form-control" name="phone_number"
                                                   required>
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-6">
                                            <label class="input__label">Address Type</label>
                                            <select name="address_type" id="address_type" class="form-control" required>
                                                <option value="1">Home (All day delivery)</option>
                                                <option value="2">Work (Delivery between 10 AM - 5 PM)</option>
                                            </select>
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-6">
                                            <label class="input__label">Street Address</label>
                                            <input type="text" name="address_line1" id="address_line1"
                                                   class="form-control" required="">
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-6">
                                            <label class="input__label">Apt, Suite, etc.,</label>
                                            <input type="text" name="address_line2" id="address_line2"
                                                   class="form-control" required="">
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-4">
                                            <label class="input__label">State</label>
                                            <input type="text" class="form-control" name="state" id="state" required/>
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-4">
                                            <label class="input__label">City</label>
                                            <input type="text" class="form-control" name="city" id="city" required/>
                                            <span class="error">Error</span>
                                        </div>

                                        <div class="input__filed col col-4">
                                            <label class="input__label">Postal/ZipCode</label>
                                            <input type="text" class="form-control" name="zipcode" id="zipcode"
                                                   required/>
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__filed col col-4">
                                            <label class="input__label">Select Country</label>
                                            <select class="form-control" name="country_id" id="country_id" required>
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="error">Error</span>
                                        </div>
                                        <div class="input__label check_box col col-12">
                                            <input type="checkbox" name="default_address" id="default_address"
                                                   value="1">
                                            <label for="default_address"> Use as my default address.</label>
                                        </div>
                                    </div>
                                    <div class="form__row row">
                                        <div class="col col-12">
                                            <ul class="checkout_form_btn">
                                                <li class="btn"><input type="reset" value="Reset"></li>
                                                <li class="btn"><input type="submit" value="Add Address"></li>
                                            </ul>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card my_cart_card d-none">
                            <div class="card_title">
                                <h2>Order Summary</h2>
                            </div>
                            <div class="my_cart_item_wrap">
                                @foreach($cart as $item)
                                    <div class="my_cart_item">
                                        <div class="my_cart_product_img">
                                            <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}"
                                               class="image">
                                                @if(!empty($item->products->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($item->products->productsImagesFirst->filename))
                                                    <img
                                                        src="{{ url('storage') . '/' . $item->products->productsImagesFirst->filename}}"
                                                    >
                                                @else
                                                    <img src="{{ url('storage') . '/no_image.png'}}"
                                                    >
                                                @endif
                                            </a>
                                        </div>
                                        <div class="my_cart_product_desc">
                                            <p>
                                                <a href="{{ route('product-detail', array('slug2' => $item->products->slug2, 'slug3' => $item->products->slug3, 'slug4' =>  $item->products->slug)) }}">{{ $item->products->name }}</a>
                                            </p>
                                            <ul>
                                                <li><label for="">Seller :</label> <span><a
                                                            href="javascript:;">{{ $item->products->user->name }} {{ $item->products->user->last_name }}</a></span>
                                                </li>
                                                <li><label for="">Purchase Type
                                                        :</label><span>{{ $item->options->extra_detail['product_type'] }}</span>
                                                </li>
                                                @if($item->options->extra_detail['product_type'] == 'Rent')
                                                    <li><label for="">Selected Date :</label>
                                                        <span>{{ date('m-d-Y',strtotime($item->options->extra_detail['from_date'])) }}  {{ date('H:i',strtotime( $item->options->extra_detail['from_time'])) }} to {{ date('m-d-Y',strtotime($item->options->extra_detail['to_date'])) }} {{ date('H:i',strtotime( $item->options->extra_detail['to_time'])) }} </span>
                                                    </li>
                                                    <li><label for="">Total Hours :</label><span>{{ $item->options->extra_detail['total_hrs'] }} hr</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                        <div class="my_cart_item_price">
                                            <h4>{{ config('constant.CURRENCY_SIGN') }}{{$item->price}}</h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col col-3">
                        <div class="card my_cart_card">
                            <div class="card_title">
                                <h2>Price Details</h2>
                            </div>
                            <div class="my_cart_price_overview">
                            <ul>
                            <div class="subscribe-part">
                            <h6>Get Exclusive Offers </h6>
                            <div class="checkout-coupon-code">
                            <input placeholder="Add offer code here" type="" name="offer_code" required="">
                            <button id="apply_offer" type="submit" class="fotm-btn">Apply</button>
                            </div>
                            </div>
                                <ul>
                                    <li><label for="">Product Price ({{ Cart::count() }} items)</label>
                                        <span>{{ config('constant.CURRENCY_SIGN') }}{{ Cart::subtotalFloat() + Cart::discountFloat()}}</span></li>
                                </ul>
                                <div class="my_cart_total_ammount">
                                    <label for="">Total Payable Amount</label>
                                    @if(Cart::discountFloat()> 0)
                                    <label>{{ config('constant.CURRENCY_SIGN') }}{{ Cart::total() }}</label>
                                    <br> * Offer applied
                                    @else
                                    <label>{{ config('constant.CURRENCY_SIGN') }}{{ Cart::total() }}</label>
                                    @endif
                                </div>

                            </div>
                            <div class="my_cart_place_btn btn">
                                <button class="btn placeOrder" id="checkout-button">
                                    <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 468 222.5">
                                        <style>.st0 {
                                                fill-rule: evenodd;
                                                clip-rule: evenodd
                                            }</style>
                                        <g id="Stripe">
                                            <path class="st0"
                                                  d="M414 113.4c0-25.6-12.4-45.8-36.1-45.8-23.8 0-38.2 20.2-38.2 45.6 0 30.1 17 45.3 41.4 45.3 11.9 0 20.9-2.7 27.7-6.5v-20c-6.8 3.4-14.6 5.5-24.5 5.5-9.7 0-18.3-3.4-19.4-15.2h48.9c0-1.3.2-6.5.2-8.9zm-49.4-9.5c0-11.3 6.9-16 13.2-16 6.1 0 12.6 4.7 12.6 16h-25.8zM301.1 67.6c-9.8 0-16.1 4.6-19.6 7.8l-1.3-6.2h-22v116.6l25-5.3.1-28.3c3.6 2.6 8.9 6.3 17.7 6.3 17.9 0 34.2-14.4 34.2-46.1-.1-29-16.6-44.8-34.1-44.8zm-6 68.9c-5.9 0-9.4-2.1-11.8-4.7l-.1-37.1c2.6-2.9 6.2-4.9 11.9-4.9 9.1 0 15.4 10.2 15.4 23.3 0 13.4-6.2 23.4-15.4 23.4zM223.8 61.7l25.1-5.4V36l-25.1 5.3zM223.8 69.3h25.1v87.5h-25.1zM196.9 76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7 15.9-6.3 19-5.2v-23c-3.2-1.2-14.9-3.4-20.8 7.4zM146.9 47.6l-24.4 5.2-.1 80.1c0 14.8 11.1 25.7 25.9 25.7 8.2 0 14.2-1.5 17.5-3.3V135c-3.2 1.3-19 5.9-19-8.9V90.6h19V69.3h-19l.1-21.7zM79.3 94.7c0-3.9 3.2-5.4 8.5-5.4 7.6 0 17.2 2.3 24.8 6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6C67.5 67.6 54 78.2 54 95.9c0 27.6 38 23.2 38 35.1 0 4.6-4 6.1-9.6 6.1-8.3 0-18.9-3.4-27.3-8v23.8c9.3 4 18.7 5.7 27.3 5.7 20.8 0 35.1-10.3 35.1-28.2-.1-29.8-38.2-24.5-38.2-35.7z"></path>
                                        </g>
                                    </svg>
                                    Pay
                                </button>
                            </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('front.layouts.app-footer')
    <div id="CheckoutAddressPopup" class="fancy_checkout_address" style="display:none">
        <div class="checkout_address_form">
            <div class="checkout_form_title">
                <h3>Edit Address</h3>
            </div>
            <form action="" id="shipping_details_upd" method="post" data-parsley-validate="">
                <input type="hidden" name="shipping_id" id="shipping_id" class="shipping_id" value="">
                <div class="form__row row">
                    <div class="col col-6 input__filed">
                        <label class="input__label">First Name</label>
                        <input type="text" name="name" id="name" class="form-control name" required="">
                        <span class="error">Error</span>
                    </div>
                    <div class="col col-6 input__filed">
                        <label class="input__label">Last Name</label>
                        <input type="text" name="last_name" id="last_name" class="form-control last_name" required="">
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-2">
                        <label class="input__label">Phone Number</label>
                        <select name="phone_number_type" id="phone_number_type" class="form-control phone_number_type"
                                required>
                            <option value="Mobile">Mobile</option>
                            <option value="Home">Home</option>
                            <option value="Business">Business</option>
                        </select>
                    </div>
                    <div class="input__filed col col-4">
                        <label class="input__label">Phone Number</label>
                        <input type="text" id="phone_number" class="form-control phone_number" name="phone_number"
                               required>
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-6">
                        <label class="input__label">Address Type</label>
                        <select name="address_type" id="address_type" class="form-control address_type" required>
                            <option value="1">Home (All day delivery)</option>
                            <option value="2">Work (Delivery between 10 AM - 5 PM)</option>
                        </select>
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-6">
                        <label class="input__label">Street Address</label>
                        <input type="text" name="address_line1" id="address_line1" class="form-control address_line1"
                               required="">
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-6">
                        <label class="input__label">Apt, Suite, etc.,</label>
                        <input type="text" name="address_line2" id="address_line2" class="form-control address_line2"
                               required="">
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-4">
                        <label class="input__label">State</label>
                        <input type="text" class="form-control state" name="state" id="state" required/>
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-4">
                        <label class="input__label">City</label>
                        <input type="text" class="form-control city" name="city" id="city" required/>
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-4">
                        <label class="input__label">Postal/ZipCode</label>
                        <input type="text" class="form-control zipcode" name="zipcode" id="zipcode" required/>
                        <span class="error">Error</span>
                    </div>
                    <div class="input__filed col col-4">
                        <label class="input__label">Select Country</label>
                        <select class="form-control country_id" name="country_id" id="country_id" required>
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <span class="error">Error</span>
                    </div>
                    <div class="input__label col col-12">
                        <div class="checkbox_wrapper">
                            <input type="checkbox" name="default_address" id="default_address" value="1"
                                   class="default_address">
                            <label for="default_address"> Use as my default address.</label>
                        </div>
                    </div>
                </div>
                <div class="form__row row">
                    <div class="col col-12">
                        <ul class="checkout_form_btn">
                            <li class="btn"><input type="button" value="Cancel"></li>
                            <li class="btn"><input type="submit" value="Update Address"></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('extra-js')
    <script>
        let shippingDetailSave = '{{route('shippingDetail-save')}}';
        let EditShippingAddressFetch = '{{route('edit-shipping-address-fetch')}}';
    </script>
    <script type="text/javascript">
        var stripe = Stripe("{{ env('STRIPE_KEY') }}");
        var checkoutButton = document.getElementById("checkout-button");
        var  offer_count = 0
        checkoutButton.addEventListener("click", function () {
            let shipping_address_id = $('input[name="deliver_address"]:checked').val();

            if (shipping_address_id != '' && shipping_address_id != undefined) {
                $('.card_section').addClass('section-loader');

                fetch("{{ route('checkout') }}?shipping_address_id=" + shipping_address_id, {
                    method: "POST",
                })
                    .then(function (response) {
                        return response.json();
                    })
                    .then(function (session) {
                        return stripe.redirectToCheckout({sessionId: session.id});
                        $('.card_section').removeClass('section-loader');

                    })
                    .then(function (result) {
                        if (result.error) {
                            //  alert(result.error.message);
                            $.notifyBar({cssClass: "error", html: result.error.message});
                        }
                    })
                    .catch(function (error) {
                        //console.error("Error:", error);
                        $.notifyBar({cssClass: "error", html: error});

                    });
            } else {
                $.notifyBar({cssClass: "error", html: 'Shipping Address is Required'});
            }
        });

        //offer code apply
        $('#apply_offer').on("click",function(){
            if(offer_count == 0)
            {
                offer_count++;
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                let offer_code = $("input[name=offer_code]").val();
                let cart_qty = '{{ Cart::count() }}';
                let cart_total = '{{Cart::total()}}';
                cart_total = cart_total.replace(/,/g, "");
            $.ajax({
                type: "POST",
                url: "{{route('cart-offer-apply')}}",
                data: { _token: CSRF_TOKEN, cart_total:cart_total,offer_code:offer_code},
                success: function(result) {
                    if(result == 'invalid')
                    {
                        $( ".my_cart_price_overview" ).append('<div class="my_cart_total_ammount"><label for="" class="invalid_code">Invalid code..!</label></div>');
                    }else{
                        console.log(result);
                        let final = parseFloat(cart_total) - parseFloat(result);
                        $( ".my_cart_price_overview" ).html('<div class="my_cart_total_ammount"><label for="">Offer Apply Amount</label><label id="total"> $'+final +'.00 </label><div class="offer_applied"></div></div>');
                        $( ".my_cart_price_overview" ).load(window.location.href + " .my_cart_price_overview" );
                    }
                },
                error: function(result) {
                    alert('error');
                }
            });
        }else{
            alert("You already applyed offer");
            $('#apply_offer').prop('disabled', true);
        }
     });
     //cancel offer
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
