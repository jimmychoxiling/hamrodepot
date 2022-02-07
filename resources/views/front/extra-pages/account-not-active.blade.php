@extends('front.layouts.app')

@section('content')
    @include('front.layouts.app-header')
    <div id="content" class="main-content">
        <section class="card_section account_not_active">
            <div class="container">
                <div class="row">
                    <div class="col col-12 text-center">
                        <h3><i class="fa fa-info-circle" aria-hidden="true"></i></h3>
                        <h5>Your Account is not activated.</h5>
                        <p> Please contact your admin to activate your account.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('front.layouts.app-footer')
@endsection
