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
                                <li>Brands</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="main_brand_section card_section">
            <div class="container">
                <div class="row">
                @foreach($brands as $brand)
                    <div class="col col-3">
                        <div class="card brnad_logo_item">
                            <a href="{{ route('brands-products', array('slug2' => $brand->slug)) }}">
                                @if(!empty($brand->image) && \Illuminate\Support\Facades\Storage::exists($brand->image))
                                    <img
                                        src="{{ url('storage') . '/' . $brand->image}}"
                                        alt="{{ $brand->name }}">
                                @else
                                    <img src="{{ url('storage') . '/no_image.png'}}"
                                         alt="{{ $brand->name }}">
                                @endif
                                <div class="brnad_logo_overlay">
                                    <p>{{ $brand->name }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
    @include('front.layouts.app-footer')
@endsection
