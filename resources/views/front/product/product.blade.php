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
                            @if(isset($category) && isset($sub_category) && isset($type))
                            <li><a href="{{ route('hardware', array('slug2' => $category->slug)) }}"><i
                                        class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a></li>
                            <li>
                                <a
                                    href="{{ route('hardware', array('slug2' => $category->slug)) }}">{{ $category->name }}</a>
                            </li>
                            <li>
                                <a
                                    href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug)) }}">{{ $sub_category->name }}
                                </a>
                            </li>
                            <li> {{ $type->name }} </li>
                            @elseif(isset($category) && isset($sub_category))

                            <li><a href="{{ route('hardware', array('slug2' => $category->slug)) }}"><i
                                        class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a></li>
                            <li>
                                <a
                                    href="{{ route('hardware', array('slug2' => $category->slug)) }}">{{ $category->name }}</a>
                            </li>
                            <li>{{ $sub_category->name }}</li>
                            @elseif(isset($brand))
                            <li><a href="{{ url('/') }}"><i class="fa fa-long-arrow-left"
                                        aria-hidden="true"></i>Back</a></li>
                            <li><a href="{{ route('brands') }}">Brands</a></li>
                            <li>{{ $brand->name }}</li>
                            @else
                            <li><a href="{{ url('/') }}"><i class="fa fa-long-arrow-left"
                                        aria-hidden="true"></i>Back</a></li>
                            <li>Search</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if( (isset($all_product_count) && $all_product_count > 0) || count($all_products)>0)
    <section class="main_product_list sub_category_product_sec" id="product_sorting_section">
        <div class="container">
            <div class="row sub_category_title_sorting">
                <div class="col col-8">
                    <div class="sub_category_title">
                        <h4> @if(isset($category) && isset($sub_category))
                            {{ $sub_category->name }}
                            @elseif(isset($brand))
                            {{ $brand->name }}
                            @else
                            Search
                            @endif
                            @if(isset($all_product_count))
                            (<span>{{ $all_product_count }}</span> items found)
                            @else
                            (<span>{{ count($all_products) }}</span> items found)
                            @endif
                        </h4>
                    </div>
                </div>
                <div class="col col-4">
                    <div class="sub_category_sorting">
                        <label for="">Sort by</label>
                        <select name="sort_by" id="product_sort_by">
                            <option value="recommended">Recommended</option>
                            <option value="top-rated">Top Rated</option>
                            <option value="price_ltoh">Price: Low to High</option>
                            <option value="price_htol">Price: High to Low</option>
                            <option value="a-z">Alphabetical: A-Z</option>
                            <option value="z-a">Alphabetical: Z-A</option>
                            <option value="recent-first">Date Added: Most Recent First</option>
                            <option value="recent-last">Date Added: Most Recent Last</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col col-12">
                    <div class="mian_list_content">
                        @include('front.product.left-sidebar')
                        <div class="product_list_wrap">
                            <div id="product_list_wrap">
                                <div class="sb_product_list__inner" id="product-list">
                                    @include('front.product.product-list')
                                </div>
                                <div class="product_load_more btn">
                                    @if(isset($category) && isset($sub_category))
                                    <a href="javascript:;"
                                        class="btn load-more @if(count($all_products) <= env('PRODUCTS_LIMIT')) display-none @endif "
                                        data-slug3="{{$sub_category->slug }}" data-slug2="{{$category->slug}}"
                                        @if(!empty($type)) data-slug4="{{$type->slug}}" @endif>load
                                        more <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    @else
                                    <a href="javascript:;" class="btn load-more " data-sub_id="" data-cat_id="">load
                                        more <i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                    @endif
                                </div>
                            </div>
                            @include('front.product.no-product')
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none mobile_filter_button">
            <a href="javascript:;" class="filter_btn"><i class="fa fa-filter" aria-hidden="true"></i> Filter</a>
            <a href="javascript:;" class="filter_cancel_btn d-none"><i class="fa fa-times" aria-hidden="true"></i>
                Close</a>
        </div>
    </section>
    @endif
    @include('front.product.no-product')
    @if(isset($also_like_products))
    <section class="feature-section related_products">
        <div class="container">
            <div class="feature-top">
                <div class="left">
                    <div class="title">
                        <div class="top-title">Hot items</div>
                        <h2>You May Also Like</h2>
                    </div>
                </div>
            </div>
            <div class="feature-list related_products_slider">
                @foreach($also_like_products as $also_like_product)
                <div class="box">
                    <div class="feature-img">
                        @if($also_like_product->sell_type == 'Rent')
                            <div class="product-badge"><span>Available for Rent</span></div>
                        @endif
                        <div class="image">
                            <a
                                href="{{ route('product-detail', array('slug2' => $also_like_product->category->slug, 'slug3' => $also_like_product->sub_category->slug,'slug4' => $also_like_product->slug)) }} ">
                                @if(!empty($also_like_product->productsImagesFirst->filename) &&
                                \Illuminate\Support\Facades\Storage::exists($also_like_product->productsImagesFirst->filename))
                                <img src="{{ url('storage') . '/' . $also_like_product->productsImagesFirst->filename}}"
                                    alt="{{ $also_like_product->name }}">
                                @else
                                <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $also_like_product->name }}">
                                @endif
                            </a>
                        </div>
                    </div>
                    <div class="content">
                        <div class="ht-product-content-inner">
                            <div class="ht-product-categories"><a
                                    href="{{ route('hardware', array('slug2' => $also_like_product->category->slug)) }}">{{ $also_like_product->category->name }}</a>
                            </div>
                            <h4 class="ht-product-title"><a
                                    href="{{ route('product-detail', array('slug2' => $also_like_product->category->slug, 'slug3' => $also_like_product->sub_category->slug,'slug4' => $also_like_product->slug)) }} ">{{ $also_like_product->name }}</a>
                            </h4>
                            <div class="ht-product-price">
                                <span class="price">
                                    @if($also_like_product->sell_type == 'Sell')
                                    <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $also_like_product->price }}</ins>
                                    @else
                                    <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $also_like_product->price }} /
                                        hour</ins>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>

@include('front.layouts.app-footer')
@endsection
@section('extra-js')
<script>
var slug2 = "";
var slug3 = "";
var slug4 = "";
var cat_id = "";
var brandId = "";
var search = "";
var productFilter = "{{ route('products-filter') }}";
pageName = "";
var whishListCheck = "{{ route('wishlist-add-remove') }}";
var loginUrl = "{{route('login')}}";

<?php
            if (isset($category) && isset($sub_category)) {
            ?>
slug2 = "{{ $category->slug }}";
slug3 = "{{ $sub_category->slug }}";
<?php
            }
            $catId = '';
            $search = '';
            // dd(Request::get('cat'));
            if (Request::get('cat') != '') {
                $catId = Request::get('cat');
            }
            if (Request::get('search') != '') {
                $search = Request::get('search');
            }
            if ($search != '' || $catId) {
            ?>
productFilter = "{{ route('search-filter') }}";
cat_id = "<?= $catId ?>";
search = "<?= $search ?>";
<?php
            }
            if (isset($brand)) {
            ?>
productFilter = "{{ route('brand-filter') }}";
brandId = <?= $brand->id ?>;
<?php
            }
            if(isset($type)) {
            ?>
slug4 = "{{$type->slug}}"
<?php
        }
        ?>
</script>
@endsection
