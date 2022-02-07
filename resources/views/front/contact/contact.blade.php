@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<div id="content" class="main-content">
    <section class="contact_us_sec card_section">
        <div class="common_banner contact_us_banner" style="background: #fff url(images/authentication_banner.jpg ) center/ cover fixed;">
            <div class="common_banner_inner">
                <h1>Contact Us</h1>
                <ul class="banner_breadcrumb">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
        <div class="container">
            <div class="row ">
                <div class="col col-9">
                    <div class="contact_form_wrap row">
                        <div class="form_inner col col-3 contact_form_bg" style="background: #fff url(images/contact_us_fomr_banner.jpg ) center/ cover;"></div>
                        <div class="form_inner card col col-9">
                            <div class="card_title">
                                <h2>Get in touch with Us</h2>
                            </div>
                            <form action="" id="contact_us_update" method="post" data-parsley-validate="">
                                @csrf
                                <div class="form__row row">
                                    <div class="input__filed col col-6">
                                        <label class="input__label">Full Name</label>
                                        <input type="text" class="form-control" name="full_name" required="">
                                        <span class="error">Error</span>
                                    </div>
                                    <div class="input__filed col col-6">
                                        <label class="input__label">Email </label>
                                        <input type="email" class="form-control" name="email" required="">
                                        <span class="error">Error</span>
                                    </div>
                                    <div class="input__filed col col-6">
                                        <label class="input__label">Phone </label>
                                        <input type="number" class="form-control" name="phone" required="">
                                        <span class="error">Error</span>
                                    </div>
                                    <div class="input__filed col col-6">
                                        <label class="input__label">Subject </label>
                                        <input type="text" class="form-control" name="subject" required="">
                                        <span class="error">Error</span>
                                    </div>
                                    <div class="input__filed col col-12">
                                        <label class="input__label">Message </label>
                                        <textarea id="" cols="" rows="5" name="message" class="form-control"></textarea>
                                        <span class="error">Error</span>
                                    </div>
                                </div>
                                <div class="form__row">
                                    <div class="btn">
                                        <input type="submit" id="contact_us_btn" value="Send">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col col-3">
                    <div class="card contact_page_details">
                        <div class="card_title">
                            <h2>Connect with us:</h2>
                        </div>
                        <div class="contact_details_inner">
                            <div class="contact_details_step">
                                <p>For Support or any question just call or email us :</p>
                            </div>
                            <div class="contact_details_step">
                                <ul>
                                    <li>
                                        <h4 class="contact_info_title"><i class="fa fa-phone" aria-hidden="true"></i> Call Us</h4>
                                        <p><a href="tel:+0-123-456-7890"> +0 123 456 7890 </a></p>
                                    </li>
                                    <li>
                                        <h4 class="contact_info_title"><i class="fa fa-envelope" aria-hidden="true"></i> Drop a mail</h4>
                                        <p><a href="mailto:support@hardwarestore.com">support@hardwarestore.com</a>
                                        </p>
                                    </li>
                                    <li>
                                        <h4 class="contact_info_title"><i class="fa fa-map-marker" aria-hidden="true"></i> Location</h4>
                                        <p>347 Calico Drive, FRESNO, California - 93755</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="contact_map_sec">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12780.75638115895!2d-119.79875475919675!3d36.79001636333673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8094677de21d2961%3A0x189ac4b2aab86bbc!2sFresno%2C%20CA%2093755%2C%20USA!5e0!3m2!1sen!2sin!4v1622015114713!5m2!1sen!2sin" width="" height="" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </section>

</div>
@include('front.layouts.app-footer')
@endsection
@section('extra-js')
<script>
    let contactUsUrl = "{{route('make-contact')}}";
</script>
@endsection