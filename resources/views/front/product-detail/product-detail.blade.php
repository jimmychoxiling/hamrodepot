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
                            <li>
                                <a href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug)) }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a>
                            </li>
                            <li>
                                <a href="{{ route('hardware', array('slug2' => $category->slug)) }}">{{ $category->name }}</a>
                            </li>
                            <li>
                                <a href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug)) }}">{{ $sub_category->name }}</a>
                            </li>
                            @if(isset($type))
                            <li>
                                <a href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug, 'slug4' => $type->slug)) }}">{{ $type->name }}</a>
                            </li>
                            @endif
                            <li>{{ $product->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="main_single_product">
        <div class="container">
            <div class="row">
                <div class="col col-6">
                    <div class="single_image_slider_wrap">
                        <div class="product_image_slider">
                            @foreach($product->productsImages as $productsImages)
                            @if(!empty($productsImages->filename) && \Illuminate\Support\Facades\Storage::exists($productsImages->filename))
                            <div class="item">
                                <a data-fancybox="gallery" href="{{ url('storage') . '/' . $productsImages->filename}}">
                                    <img src="{{ url('storage') . '/' . $productsImages->filename}}" alt="">
                                </a>
                            </div>
                            @endif
                            @endforeach
                            @if(count($product->productsImages) == 0)
                            <div class="item">
                                <a data-fancybox="gallery" href="{{ url('storage') . '/no_image.png'}}">
                                    <img src="{{ url('storage') . '/no_image.png'}}" alt="">
                                </a>
                            </div>
                            @endif
                        </div>
                        <div class="product_image_thumb_slider">
                            @foreach($product->productsImages as $productsImages)
                            @if(!empty($productsImages->filename) && \Illuminate\Support\Facades\Storage::exists($productsImages->filename))
                            <div class="item">
                                <img src="{{ url('storage') . '/' . $productsImages->filename}}" alt="">
                            </div>
                            @endif
                            @endforeach
                            @if(count($product->productsImages) == 0)
                            <div class="item">
                                <img src="{{ url('storage') . '/no_image.png'}}" alt="">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col col-6">
                    <div class="sg_prouct_info_wrap">
                        <div class="product__title">
                            <h1>{{ $product->name }}</h1>
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="sg_product_info_step">
                            <label for="">Customer Reviews</label>
                            <div class="sb_product__rating">
                                <div class="common-rating" data-average="{{$avg_rating}}" data-id="2"></div>
                                <span>&nbsp; ({{$all_ratings}})</span>
                            </div>
                        </div>
                        <div class="sg_product_info_step">
                            <label for="">Specials Price</label>
                            <div class="sb_product__price">
                                @if($product->sell_type == 'Sell')
                                <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $product->price }}</ins>
                                @else
                                <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $product->price }} / hour</ins>
                                @endif
                            </div>
                        </div>
                        <div class="sg_product_info_step">
                            <label for="">Quantity</label>
                            <div class="sg_product_quantity">
                                <span class="counter-btn minus"><i class="fa fa-minus"></i></span>
                                <input class="output" type="number" name="" id="X" value="1">
                                <!-- <div class="output" id="x" contenteditable="">1</div> -->
                                <span class="counter-btn plus"><i class="fa fa-plus"></i></span>
                            </div>
                        </div>
                        <p class="out-of-stock @if($product->stock == '0') @else display-none @endif"> Out Of
                            Stock!</p>

                        <div class="sg_product_info_step">
                            <div class="sg_action_btn_wrap">
                                @if($product->sell_type == 'Sell')
                                <div class="btn add_to_cart">
                                    <a href="@if($product->stock == '0' || $product->cartCheck == true){{route('cart')}} @else javascript:; @endif" class="@if($product->cartCheck == false)addCart @endif" data-id="{{ $product->id }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        @if($product->cartCheck == true) Go to Cart @else Add to cart @endif
                                    </a>
                                </div>
                                @else
                                <div class="btn buy_rent">
                                    <a href="@if($product->cartCheck == true){{route('cart')}} @else javascript:; @endif" id="rentCartBtn" class="@if($product->cartCheck == false) RentCart @endif"><i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                        @if($product->cartCheck == true) Go to Cart @else Rent Now @endif</a>
                                </div>
                                @endif
                                <div class="btn add_to_wishlist">
                                    <a href="javascript:;" class="whishListCheck" data-id="{{ $product->id }}">
                                        @if(!$product->wishlistCheck)
                                        <i class="fa fa-heart" aria-hidden="true"></i> Add to Wishlist
                                        @else
                                        <i class="fa fa-check" aria-hidden="true"></i> Added in Wishlist
                                        @endif
                                    </a>
                                </div>
                            </div>
                            <div class="sg_purchase_rent_form">
                                <form action="" id="rentCountForm" method="post" autocomplete="off" data-parsley-validate="">
                                    <div class="sg_purchase_close_btn"><i class="fa fa-times" aria-hidden="true"></i>
                                    </div>
                                    <div class="sg_form_wrap">
                                        <div class="form_row">
                                            <div class="sg_rent_input_title">Select Your Date</div>
                                        </div>
                                        <div class="form_row">
                                            <div class="input__filed">
                                                <label class="input__label">From</label>
                                                <input type="date" name="from_date" id="from_date" class="form-control" required="" placeholder="from">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed">
                                                <label class="input__label">To</label>
                                                <input type="date" name="to_date" id="to_date" class="form-control" required="" placeholder="from">
                                                <span class="error">Error</span>
                                            </div>
                                        </div>
                                        <div class="form_row">
                                            <div class="sg_rent_input_title">Select Your Time</div>
                                        </div>
                                        <div class="form_row">
                                            <div class="input__filed">
                                                <label class="input__label">From</label>
                                                <input type="time" name="from_time" id="from_time" class="form-control" required="" placeholder="from">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed">
                                                <label class="input__label">To</label>
                                                <input type="time" name="to_time" id="to_time" class="form-control" required="" placeholder="from">
                                                <span class="error">Error</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider_line"></div>
                                    <div class="sg_purchase_rent_total">
                                        <div class="sg_rent_list">
                                            <ul>
                                                <li><label for="">Total Hours</label> <span class="total_hrs">00 Hr</span></li>
                                            </ul>
                                        </div>
                                        <div class="divider_line"></div>
                                        <div class="sg_rent_total">
                                            <label for="">Total Price</label>
                                            <div class="sg_rent_value">
                                                <h4 class="total_price">{{ config('constant.CURRENCY_SIGN') }} 00.00</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="divider_line"></div>
                                    <div class="sg_purchase_fomr_btn btn">
                                        <input type="hidden" value="" id="total_hrs">
                                        <input type="hidden" value="" id="total_price">
                                        <input type="hidden" value="{{ $product->price }}" id="pro_price">
                                        <a class="addCartRent disabled" data-id="{{ $product->id }}"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Add To Cart</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sg_product_info_step divider_line"></div>
                        <div class="sg_product_rating_wrap">
                            <div class="sg_product_rating_title">
                                <h2>Rating</h2>
                            </div>
                            <div class="sg_product_rating_inner">
                                <div class="sg_product_total_rating">
                                    <h2><span id="avg_rating"> {{$avg_rating}}</span> <i class="fa fa-star" aria-hidden="true"></i>
                                    </h2>
                                    <label for=""><span id="all_rating">{{$all_ratings}}</span> Ratings</label>
                                    @if(auth()->check())
                                    <div class="sg_product_add_rating">
                                        <a href="#!">Add Rating</a>
                                    </div>
                                    @endif
                                </div>
                                <div class="sg_product_progress_rating" id="ratings">
                                    <ul id="ratingProgress">
                                        @foreach($productProgressBars as $key=>$progress)
                                        <li class="sg_progress_item">
                                            <label for=""> {{$key + 1}} <i class="fa fa-star" aria-hidden="true"></i></label>
                                            <div class="progress">
                                                <div class="progress-bar" style="{{'width:'.$progress['percentage']. '%'}}"></div>
                                            </div>
                                            <span>{{$progress['all_ratings']}}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="sg_add_product_rating">
                                    <div class="sg_add_product_title">
                                        <h2>Add Rating</h2>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Doloremque
                                            dolorum consectetur, a eaque fuga minus.</p>
                                    </div>
                                    <div class="sg_add_product_starts" id="products_stars">
                                        <div class="my-rating" data-average="{{$product->product_rating->rating}}" data-id="1" id="pro_ratings"></div>
                                    </div>
                                    <div class="sg_add_product_btn btn">
                                        <a href="#!" class="btn submit-rating" data-product="{{$product->id}}">Submit </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="divider_line"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-6">
                    <div class="sg_seller_details">
                        <div class="sg_seller_inner">
                            <div class="sg_seller_profile">
                                <div class="image">
                                    @if(!empty($product->user->image) && \Illuminate\Support\Facades\Storage::exists($product->user->image))
                                    <img src="{{ url('storage') . '/' . $product->user->image}}" alt="{{ $product->user->name }} {{ $product->user->last_name }}">
                                    @else
                                    <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $product->user->name }} {{ $product->user->last_name }}">
                                    @endif
                                </div>
                            </div>
                            <div class="sg_seller_name_location">
                                <h3>{{ $product->user->name }}</h3>
                                @if($product->user->country != '')
                                <label for=""><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $product->user->country->name }}
                                </label>
                                @endif
                            </div>
                            <div class="btn">
                                <a href="javascript:;" data-fancybox data-src="#ContactSellerPopup">Contact
                                    Seller</a>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($product->user->sellerHours) > 0 && $product->sell_type == 'Rent')
                <div class="col col-6">
                    <div class="sg_shop_hours">
                        <h3>Opening hours:</h3>
                        <ul>
                            @foreach($product->user->sellerHours as $hour)
                            <li><label for="">{{$hour->day}}</label>
                                @if($hour->isOpen == 0)
                                <span>Closed</span>
                                @else
                                <span>{{date('h:i A', strtotime($hour->opening_time))}} To {{date('h:i A', strtotime($hour->closing_time))}}</span>
                                @endif
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
            </div>
            <div class="row">
                <div class="col col-12">
                    <div class="sg_product_decs_wrap">
                        <div class="accordion-wrapper">
                            @if($product->specifications != '')
                            <div class="accordion-item">
                                <div class="accordion-title">
                                    <h3><i class="fa fa-caret-right" aria-hidden="true"></i> Specifications</h3>
                                </div>
                                <div class="accordion-content">
                                    {!! $product->specifications !!}
                                </div>
                            </div>
                            @endif
                            @if($product->product_overview != '')
                            <div class="accordion-item">
                                <div class="accordion-title">
                                    <h3><i class="fa fa-caret-right" aria-hidden="true"></i> Product Overview
                                    </h3>
                                </div>
                                <div class="accordion-content">
                                    {!! $product->product_overview !!}
                                </div>
                            </div>
                            @endif

                            @if($product->easy_returns != '')
                            <div class="accordion-item">
                                <div class="accordion-title">
                                    <h3><i class="fa fa-caret-right" aria-hidden="true"></i> Easy Returns</h3>
                                </div>
                                <div class="accordion-content">
                                    {!! $product->easy_returns !!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div id="ContactSellerPopup" class="fancy_contact_seller" style="display:none">
    <div class="sg_seller_details">
        <div class="sg_seller_inner">
            <div class="sg_seller_profile">
                <div class="image">
                    @if(!empty($product->user->image) && \Illuminate\Support\Facades\Storage::exists($product->user->image))
                    <img src="{{ url('storage') . '/' . $product->user->image}}" alt="{{ $product->user->name }} {{ $product->user->last_name }}">
                    @else
                    <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $product->user->name }} {{ $product->user->last_name }}">
                    @endif
                </div>
            </div>
            <div class="sg_seller_name_location">
                <h3>{{ $product->user->name }} {{ $product->user->last_name }}</h3>
                @if($product->user->country != '')
                <label for=""><i class="fa fa-map-marker" aria-hidden="true"></i> {{ $product->user->country->name }}</label>
                @endif
            </div>
        </div>
        <div class="sg_seller_decs">
            <h4>Contact or Inquiry via : </h4>
            <ul>
                @if($product->user->phone_number != '')
                <li><a href="{{ $product->user->phone_number }}"><i class="fa fa-phone" aria-hidden="true"></i>{{ $product->user->phone_number }}
                    </a></li>
                @endif
                <li><a href="mailto:{{ $product->user->email }}"><i class="fa fa-envelope" aria-hidden="true"></i> {{ $product->user->email }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>



@include('front.layouts.app-footer')
@endsection
@section('extra-js')
<script>
    var gotocart = "{{route('cart')}}";
    var myrating = "{{$product->product_rating->rating}}";
    pageName = "product-detail";
    var whishListCheck = "{{ route('wishlist-add-remove') }}";
    let productStock = "{{$product->stock}}";
    var addRating = "{{ route('product-rating') }}";
    $("#from_date").prop("min", moment(new Date()).format('YYYY-MM-DD'));
    $("#to_date").prop("min", moment(new Date()).format('YYYY-MM-DD'));
</script>
@endsection
