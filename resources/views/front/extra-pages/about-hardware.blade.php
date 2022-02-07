@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <!-- PAGE CONTENT -->
    <div id="content" class="main-content">

    <!-- <section class="breadcrumb_section">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="http://127.0.0.1:8000"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a></li>
                            <li>About Hardware Store</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    
    <section class="about_hw_sec">
        <div class="container">
            <div class="row">
                <div class="col col-6">
                    <div class="about_hw_image">
                        <img src="images/banner.png" alt="">
                    </div>
                </div>
                <div class="col col-6">
                    <h2>About Hamrodepot </h2>
                    <p>There are many variations of <a href="#!">passages</a> of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>
                    <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
                    <ul>
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
                        <li>Praesent vitae lorem ut est lacinia lacinia.</li>
                        <li>Integer et velit a lorem accumsan suscipit.</li>
                        <li>Etiam at ipsum auctor lectus commodo convallis.</li>
                        <li>Duis consequat risus sed arcu blandit vulputate.</li>
                        <li>In id odio commodo, porttitor purus nec, aliquam ligula.</li>
                        <li>Mauris non purus id nisl commodo facilisis.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="about_hw_slider_sec">
        <div class="container-fluid">
            <div class="row">
                <div class="col col-12">
                    <div class="about_hw_slider">
                        <div class="about_hw_item" style="background-image: url(images/slider_1.jpg);"></div>
                        <div class="about_hw_item" style="background-image: url(images/slider_2.jpg);"></div>
                        <div class="about_hw_item" style="background-image: url(images/slider_3.jpg);"></div>
                        <div class="about_hw_item" style="background-image: url(images/slider_4.jpg);"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="about_hw_extra">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <h4>Where does it come from?</h4>
                    <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>

                    <h4>Where can I get some?</h4>
                    <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>
                    <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>
                </div>
            </div>
        </div>
    </section>

    </div>
    <!-- / PAGE CONTENT -->

    @include('front.layouts.app-footer')
@endsection
