@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <!-- PAGE CONTENT -->
    <div id="content" class="main-content">

    <section class="common_banner_section">
        <div class="common_banner" style="background: #fff url(images/sell_with_us_bg.jpg ) center / cover fixed;">
            <div class="common_banner_inner">
                <h1>Sell With Us</h1>
                <ul class="banner_breadcrumb">
                    <li><a href="http://127.0.0.1:8000">Home</a></li>
                    <li>Sell With Us</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="sel_with_us">
        <div class="container">
            <div class="row ">
                <div class="col col-10 mx-auto">
                    <div class="row sell_with_us_row_1">
                        <div class="col col-6">
                            <div class="sell_with_us_content">
                                <h2>Lorem ipsum</h2>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. A adipisci est aperiam fugiat ipsum nobis magnam alias! Aliquam nihil sunt sequi quos odio tenetur, nulla assumenda sed ducimus odit est!</p>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem eligendi earum fugiat deserunt praesentium dicta atque maxime cupiditate amet explicabo dolore natus quis molestiae quisquam adipisci voluptatibus non, numquam hic.</p>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores tenetur a fugit, cum asperiores consectetur. <a href="#!">info@hardwarestore.com</a></p>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis magna turpis, blandit sit amet volutpat consequat, lacinia in nunc. Integer facilisis nibh sit amet metus pharetra, quis mollis velit fermentum</p>
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="sell_with_us_image">
                                <img src="images/business_deal.svg" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row sell_with_us_row_2">
                        <div class="col col-12">
                            <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                            <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                        </div>
                    </div>
                    <div class="row sell_with_us_row_3">
                        <div class="col col-6">
                            <div class="sell_with_us_image">
                                <img src="images/sell_with_us.svg" alt="">
                            </div>
                        </div>
                        <div class="col col-6">
                            <div class="sell_with_us_content">
                                <h3>Sell your product to earn more</h3>
                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                                <div class="btn">
                                    <a href="{{route('register')}}">Sell With Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="card_section sell_with_us_register">
        <div class="container">
            <div class="row">
                <div class="col col-8 mx-auto">
                    <h3>Lorem ipsum dolor sit amet</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    <div class="btn">
                        <a href="#!">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

    </div>
    <!-- / PAGE CONTENT -->

    @include('front.layouts.app-footer')
@endsection
