@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <section class="banner-section">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-6 left-clm">
                    <div class="homeBannerMainSlider">
                        <div class="home-banner-main-slide banner-list left-clm-inner"
                             style="background-image: url(/images/banner.png)">
                            <div class="main-content">
                                <div class="banner-content">
                                    <!-- <h5>MAY 5-17</h5> -->
                                    <h2>Shop The Brand You Love Now</h2>
                                    <div class="buttonContainer btn">
                                        <a class="red-btn" href="/brands">Shop Now</a>
                                        @guest
                                            <a class="red-btn border-btn" href="{{ route('register') }}">Not a Member?
                                                Join
                                                Now!</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="home-banner-main-slide banner-list left-clm-inner"
                             style="background-image: url(/images/slide-1.jpg)">
                            <div class="main-content">
                                <div class="banner-content">
                                    <!-- <h5>MAY 5-17</h5> -->
                                    <h2>Hire Trusted Service Provider Today</h2>
                                    <div class="buttonContainer btn">
                                        <a class="red-btn" href="/service">Find One Now</a>
                                        @guest
                                            <a class="red-btn border-btn" href="{{ route('register') }}">Not a Member?
                                                Join
                                                Now!</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col col-6 right-clm">
                    <div class="right-clm-inner">
                        <div class="top-content">
                            <div class="content-title">
                                <h4>Featured Items</h4>
                            </div>
                            <div class="banner-featured-slider-single-wrapper">
                                <div class="bannerFeaturedSliderSingle">
                                    @foreach($home_products as $home_product)
                                        <div class="banner-featured-slider-single-item">
                                            <div class="banner-featured-slider-single-item-inner">
                                                @if($home_product->sell_type == 'Rent')
                                                    <div class="product-badge"><span>Available for Rent</span></div>
                                                @endif
                                                <div class="product-img">
                                                    <a href="{{ route('product-detail', array('slug2' => $home_product->category->slug, 'slug3' => $home_product->sub_category->slug,'slug4' => $home_product->slug)) }} ">
                                                        @if(!empty($home_product->productsImagesFirst->filename) &&
                                                            \Illuminate\Support\Facades\Storage::exists($home_product->productsImagesFirst->filename))
                                                            <img
                                                                src="{{ url('storage') . '/' . $home_product->productsImagesFirst->filename}}"
                                                                alt="{{ $home_product->name }}">
                                                        @else
                                                            <img src="{{ url('storage') . '/no_image.png'}}"
                                                                 alt="{{ $home_product->name }}">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product-content">
                                                    <div class="category">
                                                        <span>{{ $home_product->category->name }}</span>
                                                    </div>
                                                    <p class="title"><a
                                                            href="{{ route('product-detail', array('slug2' => $home_product->category->slug, 'slug3' => $home_product->sub_category->slug,'slug4' => $home_product->slug)) }} ">{{ $home_product->name }}</a>
                                                    </p>
                                                    <label class="price">
                                                        @if($home_product->sell_type == 'Sell')
                                                            <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $home_product->price }}</ins>
                                                        @else
                                                            <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $home_product->price }}
                                                                / hour
                                                            </ins>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="bottom-content">
                            <div class="content-title">
                                <h4>Top Selling Products</h4>
                            </div>
                            <div class="banner-featured-slider-wrapper">
                                <div class="bannerFeaturedSlider">
                                    @foreach($topProducts as $product)
                                        @if($product->product)
                                        <div class="banner-featured-slider-item">
                                            <div class="banner-featured-slider-item-inner">
                                                @if($product->product->sell_type == 'Rent')
                                                    <div class="product-badge"><span>Available for Rent</span></div>
                                                @endif
                                                <div class="product-img">
                                                    <a
                                                        href="{{ route('product-detail', array('slug2' => $product->category->slug,
                                'slug3' => $product->sub_category->slug,'slug4' => $product->product->slug)) }} ">
                                                        @if(!empty($product->product->productsImagesFirst->filename) &&
                                                        \Illuminate\Support\Facades\Storage::exists($product->product->productsImagesFirst->filename))
                                                            <img
                                                                src="{{ url('storage') . '/' . $product->product->productsImagesFirst->filename}}"
                                                                alt="{{ $product->product->name }}">
                                                        @else
                                                            <img src="{{ url('storage') . '/no_image.png'}}"
                                                                 alt="{{ $product->product->name }}">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product-content">
                                                    <h5><a
                                                            href="{{ route('product-detail', array('slug2' => $product->category->slug,
                                'slug3' => $product->sub_category->slug,'slug4' => $product->product->slug)) }} ">{{$product->product->name}}</a>
                                                    </h5>
                                                    <span class="price">
                                               @if($product->product->sell_type == 'Sell')
                                                            <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $product->product->price }}</ins>
                                                        @else
                                                            <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $product->product->price }} / hour</ins>
                                                        @endif
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="service-section">
        <div class="container-fluid">
            <div class="list">
                @foreach($home_categories1 as $home_category1)
                    <div class="box">
                        <div class="inner">
                            <div class="left">
                                <h4>{{ $home_category1->name }}</h4>
                                <div class="btn">
                                    <a href="{{ route('hardware', array('slug2' => $home_category1->slug)) }}"
                                       class="no-bg-btn">View</a>
                                </div>
                            </div>
                            <div class="image">
                                @if(!empty($home_category1->image) &&
                                \Illuminate\Support\Facades\Storage::exists($home_category1->image))
                                    <img src="{{ url('storage') . '/' . $home_category1->image}}"
                                         alt="{{ $home_category1->name }}">
                                @else
                                    <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $home_category1->name }}">
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="feature-section">
        <div class="container">
            <div class="feature-top">
                <div class="left">
                    <div class="title">
                        <div class="top-title">Hot items</div>
                        <h2>Featured Items For Your Home</h2>
                    </div>
                </div>
            </div>
            <div class="feature-list">
                @foreach($home_products as $home_product)
                    <div class="box">
                        <div class="feature-img">
                            @if($home_product->sell_type == 'Rent')
                            <div class="product-badge"><span>Available for Rent</span></div>
                            @endif
                            <div class="image">
                                <a
                                    href="{{ route('product-detail', array('slug2' => $home_product->category->slug, 'slug3' => $home_product->sub_category->slug,'slug4' => $home_product->slug)) }} ">
                                    @if(!empty($home_product->productsImagesFirst->filename) &&
                                    \Illuminate\Support\Facades\Storage::exists($home_product->productsImagesFirst->filename))
                                        <img
                                            src="{{ url('storage') . '/' . $home_product->productsImagesFirst->filename}}"
                                            alt="{{ $home_product->name }}">
                                    @else
                                        <img src="{{ url('storage') . '/no_image.png'}}"
                                             alt="{{ $home_product->name }}">
                                    @endif
                                </a>
                            </div>
                        </div>
                        <div class="content">
                            <div class="ht-product-content-inner">
                                <div class="ht-product-categories"><a
                                        href="{{ route('hardware', array('slug2' => $home_product->category->slug)) }}">{{ $home_product->category->name }}</a>
                                </div>
                                <h4 class="ht-product-title"><a
                                        href="{{ route('product-detail', array('slug2' => $home_product->category->slug, 'slug3' => $home_product->sub_category->slug,'slug4' => $home_product->slug)) }} ">{{ $home_product->name }}</a>
                                </h4>
                                <div class="ht-product-price">
                            <span class="price">
                                @if($home_product->sell_type == 'Sell')
                                    <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $home_product->price }}</ins>
                                @else
                                    <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $home_product->price }} / hour</ins>
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
    <section class="count">
        <div class="container">
            <div class="count-wrap">
                <div class="count-box">
                    <div class="number">100%</div>
                    <div class="text">Client satisfaction</div>
                </div>
                <div class="count-box">
                    <div class="number">250+</div>
                    <div class="text">Premium brands</div>
                </div>
                <div class="count-box">
                    <div class="number">9,018</div>
                    <div class="text">Items sold in 2021</div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-categorie">
        <div class="container">
            <div class="categorie-top">
                <div class="left">
                    <div class="title">
                        <div class="top-title">OUR DAILY PICKS</div>
                        <h2>Top Categories</h2>
                    </div>
                </div>
            </div>
            <div class="product-categorie-wrap">
                @foreach($home_categories as $home_category)
                    <div class="product-categorie-box">
                        <div class="product-categorie-img">
                            <a href="{{ route('hardware', array('slug2' => $home_category->slug)) }}">
                                @if(!empty($home_category->image) &&
                                \Illuminate\Support\Facades\Storage::exists($home_category->image))
                                    <img src="{{ url('storage') . '/' . $home_category->image}}"
                                         alt="{{ $home_category->name }}">
                                @else
                                    <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $home_category->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="product-categorie-name">
                            <h4>{{ $home_category->name }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="brand-section">
        <div class="container">
            <div class="title">
                <h5>Brands We Love</h5>
            </div>
            <div class="list flex">
                @foreach($home_brands as $home_brand)
                    @if(!empty($home_brand->image) && \Illuminate\Support\Facades\Storage::exists($home_brand->image))
                        <div class="brand-logo">
                            <img src="{{ url('storage') . '/' . $home_brand->image}}" alt="{{ $home_brand->name }}">
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="btn">
                <a href="{{ route('brands') }}" class="red-btn">Shop All Brands</a>
            </div>
        </div>
    </section>
    @if(count($hom_blogs) > 0)
        <section class="advice-section">
            <div class="container">
                <div class="title section-title">
                    <div class="top-title">Our Blogs</div>
                    <h2>Latest DIY & Articles</h2>
                </div>
                <div class="list flex">
                    @foreach($hom_blogs as $hom_blog)
                        <div class="box">
                            <a href="{{ route('blog-detail', array('slug2' => $hom_blog->slug)) }}">
                                <div class="image">
                                    @if(!empty($hom_blog->image) && \Illuminate\Support\Facades\Storage::exists($hom_blog->image))
                                        <img src="{{ url('storage') . '/' . $hom_blog->image}}"
                                             alt="{{ $hom_blog->name }}">
                                    @else
                                        <img src="{{ url('storage') . '/no_image.png'}}" alt="{{ $hom_blog->name }}">
                                    @endif
                                </div>
                                <div class="content">
                                    <p>{{ $hom_blog->name }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @include('front.layouts.app-footer')
@endsection
