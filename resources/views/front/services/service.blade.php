@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<div id="content" class="main-content">
    <section class="service_main_banner">
        <div class="container">
            <div class="row">
                <div class="col col-8 mx-auto">
                    <div class="service_main_banner_content">
                        <div class="service_main_banner_content_inner">
                            <h1 class="service_main_banner_title">Our Services</h1>
                            <p class="service_main_banner_desc">Hire a trusted service provider to assist you around the issues. From handyman work and furniture assembly to repairing, there is something for everyone.</p>
                            <div class="btn">
                                <!-- <a href="javascript:;" class="red-btn">Browse Services</a> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service_main_search">
        <form method="post" action="{{ route('services-filter') }}" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="row">
                    <div class="col col-12">
                        <div class="service_main_search_content">
                            <div class="row">
                                <div class="input__filed col col-3">
                                    <label class="input__label">Select Category</label>
                                    <select class="form-control" required="" name="category">
                                        <option value="">Select Category</option>
                                        @foreach($serviceCategories as $serviceCategorie)
                                        <option value="{{$serviceCategorie->id}}">{{$serviceCategorie->name}}</option>
                                        @endforeach
                                    </select>
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-3">
                                    <label class="input__label">Select Time</label>
                                    <select name="time" class="form-control" required="">
                                        <option value="">Select Time</option>
                                        @foreach (config('constant.SERVICE_TIMING') as $tk => $time)
                                        <option value="{{$tk}}">{{ $time }}</option>
                                        @endforeach
                                    </select>
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-3">
                                    <label class="input__label">Select Price</label>
                                    <div id="rangeSlider" class="range-slider">
                                        <div class="number-group">
                                            <div class="input__wrap">
                                                <input class="number-input" type="number" name="max_price" value="0"
                                                    min="0" max="{{ $max_amount }}" />
                                                <span>$</span>
                                            </div>
                                            <span>to</span>
                                            <div class="input__wrap">
                                                <input class="number-input" type="number" name="min_price"
                                                    value="{{ $max_amount }}" min="0" max="{{ $max_amount }}" />
                                                <span>$</span>
                                            </div>
                                        </div>
                                        <div class="range-group">
                                            <input class="range-input" value="0" min="0" max="{{ $max_amount }}"
                                                step="1" type="range" id="min_price" />
                                            <input class="range-input" value="{{ $max_amount }}" min="0"
                                                max="{{ $max_amount }}" step="1" type="range" id="max_price" />
                                        </div>
                                    </div>
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed  btn col col-3 mx-auto">
                                    <label class="input__label">&nbsp;</label>
                                    <input type="submit" value="Search">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </from>
    </section>

    <section class="service_main_category">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="title">
                        <div class="top-title">categories </div>
                        <h2>Browse categories</h2>
                    </div>
                    <div class="service_main_category_list_wrap">
                        @foreach($serviceCategories as $serviceCategory)
                        @php
                        $route = route('service.detail',['slug' => $serviceCategory->slug]);
                        if($serviceCategory->count() > 0){
                        $route = route('service.detail',array('slug' => $serviceCategory->slug));
                        }
                        @endphp
                        <a href="{{ $route }}" class="service_main_category_item">
                            <div class="icon">
                                @if(!empty($serviceCategory->image) &&
                                \Illuminate\Support\Facades\Storage::exists($serviceCategory->image))
                                <img class='img-responsive'
                                    src="{{ asset('storage') . '/' .  $serviceCategory->image}}">
                                @else
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                                @endif
                            </div>
                            <h5>{{$serviceCategory->name}}</h5>
                        </a>
                        @endforeach
                        <!-- <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Furniture</h5>
                        </a>
                        <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Wall Décor</h5>
                        </a>
                        <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Small Kitchen Appliances</h5>
                        </a>
                        <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Kitchenware & Tableware</h5>
                        </a>
                        <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Lighting</h5>
                        </a>
                        <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Window Treatments</h5>
                        </a>
                        <a href="javascript:;" class="service_main_category_item">
                            <div class="icon">
                                <img src="{{ asset('images/furniture.svg')}}" alt="">
                            </div>
                            <h5>Shop By Room</h5>
                        </a> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="service_detail_info">
        <div class="container">
            <div class="row">
                <div class="col col-10 mx-auto">
                    <div class="row">
                        <div class="col col-6">
                            <div class="service_detail_img">
                                <img src="{{ asset('images/set-tools-tool-kit-isolated.jpg')}}" alt="">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="service_detail_content">
                                <h2>Why choose us?</h2>
                                <p>With just one click, you can book a Multi-Skilled Craftsman from Hamrodepot Services,
                                    who is qualified to safely complete many projects to cross off your to-do list.</p>
                                <p>We're not satisfied unless the work is done correctly and is backed by a guarantee.
                                </p>
                                <ul>
                                    <li>Servicing, Repairing, Installing, and Deinstalling</li>
                                    <li>Technicians who have been background checked and trained are provided with
                                        genuine parts and fixed pricing.</li>
                                    <li>We provide service from 8 a.m. to 9 p.m. </li>
                                    <li>on a one-time basis with dedicated employees.</li>
                                    <li>Complete masking of appliances, furniture, and so on, as well as post-service
                                        cleanup</li>
                                    <li>Mechanized Equipment and Professional Cleaning Solutions are available for
                                        on-site repair.</li>
                                    <li>Trained & Background-Verified Professionals</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="c_newsletter_sec d-none">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="c_newsletter_content">
                        <div class="c_newsletter_content_inner">
                            <!-- <h2>Sign - up</h2> -->
                            <div class="icon">
                                <img src="{{ asset('images/newsletter-icn.svg')}}" alt="">
                            </div>
                            <h4>Join Our Newsletter</h4>
                            <p>Lorem ipsum dolor sit amet. Etiam ac ex sit amet arcu ultricies rhoncus vel ut nislimply
                                Dummy Text</p>
                            <form>
                                <div class="c_newsletter_form">
                                    <input type="email" name="" id="" placeholder="Your Email">
                                    <button type="submit">SubScribe</button>
                                </div>
                            </form>
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

@endsection