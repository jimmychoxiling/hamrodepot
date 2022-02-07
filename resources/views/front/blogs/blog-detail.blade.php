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
                                <li><a href="{{ route('blogs') }}">DIY & Articles</a></li>
                                <li>{{ $blog->name }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="blog_inner_sec card_section">
            <div class="container">
                <div class="row">
                    <div class="col col-8">
                        <div class="card">
                            <div class="single_blog_wrapper">
                                <div class="single_blog_images">
                                    @if(!empty($blog->image) && \Illuminate\Support\Facades\Storage::exists($blog->image))
                                        <img src="{{ url('storage') . '/' . $blog->image}}"
                                             alt="{{ $blog->name }}">
                                    @else
                                        <img src="{{ url('storage') . '/no_image.png'}}"
                                             alt="{{ $blog->name }}">
                                    @endif
                                </div>
                                <div class="single_blog_date_info">
                                    <ul>
                                        <li>
                                            <i class="fa fa-calendar"></i> {{ date('M d, Y', strtotime($blog->created_at))}}
                                        </li>
                                        <li><a href="#!"><i class="fa fa-user"></i> {{ $blog->author }}</a></li>
                                    </ul>
                                </div>
                                <div class="single_blog_title">
                                    <h1>{{ $blog->name }}</h1>
                                </div>
                                <div class="single_blog_content">
                                    {!! $blog->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('front.blogs.blog-right-sidebar')
                </div>
            </div>
        </section>
    </div>
    @include('front.layouts.app-footer')
@endsection
@section('extra-js')
    <script>
        $(function () {
            // bind change event to select
            $('#archivesblog').on('change', function () {
                var url = $(this).val(); // get selected value
                if (url) { // require a URL
                    window.location = url; // redirect
                }
                return false;
            });
        });
    </script>
@endsection
