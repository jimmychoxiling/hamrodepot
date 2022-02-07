@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <div id="content" class="main-content">
        <section class="card_section account_not_active">
            <div class="container">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h3><i class="fa fa-check" aria-hidden="true"></i></h3>
                        <h5>Your Order has been placed successfully.</h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('front.layouts.app-footer')
@endsection
