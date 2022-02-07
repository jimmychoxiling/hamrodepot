@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <div id="content" class="main-content">
        <section class="card_section account_not_active">
            <div class="container">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h3><i class="fa fa-times" aria-hidden="true"></i></h3>
                        <h5>Your Order Payment has been Cancelled. Please try again.</h5>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('front.layouts.app-footer')
@endsection
