@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<!-- PAGE CONTENT -->
<div id="content" class="main-content">

    <section class="common_banner_section">
        <div class="common_banner" style="background: #fff url(images/faq_bg.jpg ) center -340px/ cover fixed;">
            <div class="common_banner_inner">
                <h1>FAQs</h1>
                <ul class="banner_breadcrumb">
                    <li><a href="http://127.0.0.1:8000">Home</a></li>
                    <li>FAQs</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="main_faq_sec card_section">
        <div class="container">
            <div class="row">
                <div class="col col-3">
                    <div class="card faq_category_wrap">
                        <div class="faq_category_title">
                            <h3>Question Category</h3>
                        </div>
                        <div class="faq_category_list_wrap">
                            <ul class="faq_category_list_inner">
                                <li class="faq_category_item">
                                    <a href="#!" id="1" class="que_category active"><i class="fa fa-shopping-bag" aria-hidden="true"></i> Shopping guide</a>
                                </li>
                                <li class="faq_category_item">
                                    <a href="#!" id="2" class="que_category"><i class="fa fa-archive" aria-hidden="true"></i> Order questions</a>
                                </li>
                                <li class="faq_category_item">
                                    <a href="#!" id="3" class="que_category"><i class="fa fa-money" aria-hidden="true"></i> Payment issues</a>
                                </li>
                                <li class="faq_category_item">
                                    <a href="#!" id="4" class="que_category"><i class="fa fa-truck" aria-hidden="true"></i> Shipping questions</a>
                                </li>
                                <li class="faq_category_item">
                                    <a href="#!" id="5" class="que_category"><i class="fa fa-user-plus" aria-hidden="true"></i> Account and membership</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col col-9">
                    <div class="card faq_accordian_wrap">
                        <div class="accordion-wrapper">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
<!-- / PAGE CONTENT -->

@include('front.layouts.app-footer')
@endsection
@section('extra-js')
<script>
    let faqUrl = "{{route('find-faq')}}";
    pageName = "faq";
</script>
@endsection