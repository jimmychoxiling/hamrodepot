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
                                <li>{{ $category->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="main_product_list">
            <div class="container">
                <div class="row">
                    <div class="col col-12">
                        <div class="mian_list_content">
                            <div class="sidebar">
                                <h1 class="category_title">{{ $category->name }}</h1>
                                <div class="sidebar_list_wrap">
                                    <ul class="sidebar_list_inner">
                                        @foreach($sub_categories as $sub_category)
                                            <li class="sidebar_item"><a class="sidebar_link"
                                                                        href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug)) }}">{{ $sub_category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="product_list_wrap">
                                <div class="product_list__inner">
                                    @if(count($sub_categories) > 0)
                                        @foreach($sub_categories as $sub_category)
                                            <div class="product__item">
                                                <div class="product__image">
                                                    <a href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug)) }}">
                                                        @if(!empty($sub_category->image) && \Illuminate\Support\Facades\Storage::exists($sub_category->image))
                                                            <img src="{{ url('storage') . '/' . $sub_category->image}}"
                                                                 alt="{{ $sub_category->name }}">
                                                        @else
                                                            <img src="{{ url('storage') . '/no_image.png'}}"
                                                                 alt="{{ $sub_category->name }}">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="product__content">
                                                    <p>
                                                        <a href="{{ route('our-products', array('slug2' => $category->slug, 'slug3' => $sub_category->slug)) }}">{{ $sub_category->name }}</a>
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="no_data_error">
                                            <div class="no_data_inner">
                                                <div class="no_data_image">
                                                    <svg id="b21613c9-2bf0-4d37-bef0-3b193d34fc5d" data-name="Layer 1"
                                                         xmlns="http://www.w3.org/2000/svg" width="647.63626"
                                                         height="632.17383" viewBox="0 0 647.63626 632.17383">
                                                        <path
                                                            d="M687.3279,276.08691H512.81813a15.01828,15.01828,0,0,0-15,15v387.85l-2,.61005-42.81006,13.11a8.00676,8.00676,0,0,1-9.98974-5.31L315.678,271.39691a8.00313,8.00313,0,0,1,5.31006-9.99l65.97022-20.2,191.25-58.54,65.96972-20.2a7.98927,7.98927,0,0,1,9.99024,5.3l32.5498,106.32Z"
                                                            transform="translate(-276.18187 -133.91309)"
                                                            fill="#f2f2f2"/>
                                                        <path
                                                            d="M725.408,274.08691l-39.23-128.14a16.99368,16.99368,0,0,0-21.23-11.28l-92.75,28.39L380.95827,221.60693l-92.75,28.4a17.0152,17.0152,0,0,0-11.28028,21.23l134.08008,437.93a17.02661,17.02661,0,0,0,16.26026,12.03,16.78926,16.78926,0,0,0,4.96972-.75l63.58008-19.46,2-.62v-2.09l-2,.61-64.16992,19.65a15.01489,15.01489,0,0,1-18.73-9.95l-134.06983-437.94a14.97935,14.97935,0,0,1,9.94971-18.73l92.75-28.4,191.24024-58.54,92.75-28.4a15.15551,15.15551,0,0,1,4.40966-.66,15.01461,15.01461,0,0,1,14.32032,10.61l39.0498,127.56.62012,2h2.08008Z"
                                                            transform="translate(-276.18187 -133.91309)"
                                                            fill="#3bba9c"/>
                                                        <path
                                                            d="M398.86279,261.73389a9.0157,9.0157,0,0,1-8.61133-6.3667l-12.88037-42.07178a8.99884,8.99884,0,0,1,5.9712-11.24023l175.939-53.86377a9.00867,9.00867,0,0,1,11.24072,5.9707l12.88037,42.07227a9.01029,9.01029,0,0,1-5.9707,11.24072L401.49219,261.33887A8.976,8.976,0,0,1,398.86279,261.73389Z"
                                                            transform="translate(-276.18187 -133.91309)"
                                                            fill="#3bba9c"/>
                                                        <circle cx="190.15351" cy="24.95465" r="20" fill="#3bba9c"/>
                                                        <circle cx="190.15351" cy="24.95465" r="12.66462" fill="#fff"/>
                                                        <path
                                                            d="M878.81836,716.08691h-338a8.50981,8.50981,0,0,1-8.5-8.5v-405a8.50951,8.50951,0,0,1,8.5-8.5h338a8.50982,8.50982,0,0,1,8.5,8.5v405A8.51013,8.51013,0,0,1,878.81836,716.08691Z"
                                                            transform="translate(-276.18187 -133.91309)"
                                                            fill="#e6e6e6"/>
                                                        <path
                                                            d="M723.31813,274.08691h-210.5a17.02411,17.02411,0,0,0-17,17v407.8l2-.61v-407.19a15.01828,15.01828,0,0,1,15-15H723.93825Zm183.5,0h-394a17.02411,17.02411,0,0,0-17,17v458a17.0241,17.0241,0,0,0,17,17h394a17.0241,17.0241,0,0,0,17-17v-458A17.02411,17.02411,0,0,0,906.81813,274.08691Zm15,475a15.01828,15.01828,0,0,1-15,15h-394a15.01828,15.01828,0,0,1-15-15v-458a15.01828,15.01828,0,0,1,15-15h394a15.01828,15.01828,0,0,1,15,15Z"
                                                            transform="translate(-276.18187 -133.91309)"
                                                            fill="#3bba9c"/>
                                                        <path
                                                            d="M801.81836,318.08691h-184a9.01015,9.01015,0,0,1-9-9v-44a9.01016,9.01016,0,0,1,9-9h184a9.01016,9.01016,0,0,1,9,9v44A9.01015,9.01015,0,0,1,801.81836,318.08691Z"
                                                            transform="translate(-276.18187 -133.91309)"
                                                            fill="#3bba9c"/>
                                                        <circle cx="433.63626" cy="105.17383" r="20" fill="#3bba9c"/>
                                                        <circle cx="433.63626" cy="105.17383" r="12.18187" fill="#fff"/>
                                                    </svg>
                                                </div>
                                                <h2>No Data Available.</h2>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                @if($category->description != '')
                                    <div class="product_list_info">
                                        <div class="content">
                                            <h3>About {{ $category->name }}</h3>
                                            <p>{!! $category->description !!}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                                        <a href="{{ route('product-detail', array('slug2' => $also_like_product->category->slug, 'slug3' => $also_like_product->sub_category->slug,'slug4' => $also_like_product->slug)) }} ">
                                            @if(!empty($also_like_product->productsImagesFirst->filename) && \Illuminate\Support\Facades\Storage::exists($also_like_product->productsImagesFirst->filename))
                                                <img
                                                    src="{{ url('storage') . '/' . $also_like_product->productsImagesFirst->filename}}"
                                                    alt="{{ $also_like_product->name }}">
                                            @else
                                                <img src="{{ url('storage') . '/no_image.png'}}"
                                                     alt="{{ $also_like_product->name }}">
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
                                                <ins>{{ config('constant.CURRENCY_SIGN') }}{{ $also_like_product->price }} / hour</ins>
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
