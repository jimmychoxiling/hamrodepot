@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <!-- PAGE CONTENT -->
    <div id="content" class="main-content">

        <section class="common_banner_section">
            <div class="common_banner" style="background: #fff url(images/authentication_banner.jpg ) center/ cover fixed;">
                <div class="common_banner_inner">
                    <h1>About Us</h1>
                    <ul class="banner_breadcrumb">
                        <li><a href="./">Home</a></li>
                        <li>About</li>
                    </ul>
                </div>
            </div>
        </section>

        <section class="main_about_us_sec card_section">
            <div class="container">
                <div class="row">
                    <div class="col col-6">
                        <div class="about_desc">
                            <h2>About Hamrodepot</h2>
                            <p>Hamro Depo is an online platform through which hardware products are made available at reasonable prices to all ranges of new and existing customers. Our customers include individuals, contractors and firms who are in need of hardware products. We are based in Nepal and we have a vision of expanding our services to every corners of Nepal.</p>
                            <p>We are dedicated professionals who believe in providing customers with wide range of choices in the process of maximizing their utility. We believe in efficient and effective service delivery and optimum customer satisfaction. We also believe in information exchange and we value retaining our customers. We also provide our customers with up to date information and information regarding comparative analysis between various choices.</p>
                            <p>We also value our employees and we believe that “happy employees are the key to customer happiness”. Our working environment includes healthy and prosperous working conditions, performance appraisal, employee motivation, sound communication, concept of team work, and so on.</p>
                            <p>We are also committed towards building a healthy and friendly relationship with our suppliers. Information Technology and communication has made this possible.</p>
                            <p>We also have great respect towards other stakeholders and towards maintaining a sustainable environment.</p>
                            <p>Our goods range from basic to modern tools and equipment of various local and international brands.</p>
                            <p>Our service section includes hardware services such as hiring equipment and after sales service.</p>
                            <p>Currently we are focused at servicing the Eastern region of Nepal.</p>
                        </div>
                    </div>
                    <div class="col col-6">
                        <div class="about_main_img">
                            <div class="about_img_wrap">
                                <img src="images/about_2.jpg" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="about_steps_sec" style="display: none;">
            <div class="container">
                <div class="row">
                    <div class="col col-12">
                        <div class="title">
                            <h2>Lorem Ipsum</h2>
                        </div>
                        <div class="about_step_wrap">
                            <div class="about_step_item">
                                <h2>2015</h2>
                                <div class="about_step_content">
                                    <div class="about_step_content_inner">
                                        <h5>Lorem Ipsum</h5>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem aut accusamus omnis. Beatae culpa quibusdam eveniet minus. Sit corporis excepturi veniam possimus laudantium consectetur, distinctio a ab? Iusto sequi eius harum debitis officiis officia voluptatibus quod. At, nam molestiae? Facere rerum est inventore provident cumque placeat in sint consequuntur quidem!</p>
                                    </div>
                                </div>
                                <div class="about_step_image">
                                    <img src="images/about_2.jpg" alt="">
                                </div>
                            </div>
                            <div class="about_step_item">
                                <h2>2018</h2>
                                <div class="about_step_content">
                                    <div class="about_step_content_inner">
                                        <h5>Lorem Ipsum</h5>
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem aut accusamus omnis. Beatae culpa quibusdam eveniet minus. Sit corporis excepturi veniam possimus laudantium consectetur, distinctio a ab? Iusto sequi eius harum debitis officiis officia voluptatibus quod. At, nam molestiae? Facere rerum est inventore provident cumque placeat in sint consequuntur quidem!</p>
                                    </div>
                                </div>
                                <div class="about_step_image">
                                    <img src="images/about_2.jpg" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- / PAGE CONTENT -->

    @include('front.layouts.app-footer')
@endsection
