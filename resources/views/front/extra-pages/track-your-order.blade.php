@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<!-- PAGE CONTENT -->
<div id="content" class="main-content">

    <section class="trac_korder_sec card_section" style="background-image:url(images/track_bg.jpg);">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="sec_title">
                        <h1>Track Your Order </h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, dicta?</p>
                    </div>
                    <div class="track_icon">

                    </div>
                </div>
                <div class="col col-10 mx-auto">
                    <div class="track_form_wrapper card">
                        <form class="row" id="track-order-form" action="" method="POST" data-parsley-validate="">
                            <div class="col col-3">
                                <div class="input__filed">
                                    <label class="input__label">Order Number</label>
                                    <input class="form-control" type="text" name="order_number" autofocus="" required="">
                                </div>
                            </div>
                            <div class="col col-3">
                                <div class="input__filed">
                                    <label class="input__label">Your Email</label>
                                    <input class="form-control" type="email" name="email" autofocus="" required="">
                                </div>
                            </div>
                            <div class="col col-3">
                                <div class="input__filed">
                                    <label class="input__label">Billing Zip Code</label>
                                    <input class="form-control" type="text" name="zipcode" autofocus="" required="">
                                </div>
                            </div>
                            <div class="col col-3">
                                <div class="input__filed btn">
                                    <!-- <label class="input__label">&nbsp;</label> -->
                                    <input class="form-control" type="submit" value="Track Order" autofocus="" required="">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="track_map_wrap">
                        <div class="row">
                            <div class="col col-6 mx-auto">
                                <div class="card" id="traking-card">

                                </div>
                            </div>
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
    trackOrderUrl = "{{route('track-order')}}";
</script>

@endsection