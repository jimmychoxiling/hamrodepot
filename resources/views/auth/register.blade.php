@extends('front.layouts.app')
@section('content')
    <div id="page-wrapper">
        @include('front.layouts.register-login-header')
        <div id="content" class="main-content">
            <section class="authentication__sec sign_up"
                     style="background: url('{{ asset('images/banner.png') }}')  center / cover fixed;">
                <div class="container full-width">
                    <div class="row">
                        <div class="col col-7 mx-auto">
                            <div class="form_main_wrapper">
                                <div class="form__wrap">
                                    <div class="form__title">
                                        <a href="{{ route('login') }}" class="back_to_home"><i
                                                class="fa fa-long-arrow-left" aria-hidden="true"></i>Back to Login</a>
                                    </div>
                                    <div class="auth_tab_wrap row">
                                        <div class="col col-6">
                                            <div class="auth_tab_btns">
                                                <div class="form__title text-center">
                                                    <h3>Become a Buyer</h3>
                                                    <p>Create a new online account and join Rewards or link accounts
                                                        (joining or linking is optional).</p>
                                                </div>
                                                <ul>
                                                    <li><a href="javascript:;" data-rel="tab_1">Create a User
                                                            Account</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col col-6">
                                            <div class="auth_tab_btns">
                                                <div class="form__title text-center">
                                                    <h3>Become a Seller</h3>
                                                    <p>Create a new online account and join Rewards or link accounts
                                                        (joining or linking is optional).</p>
                                                </div>
                                                <ul>
                                                    <li><a href="javascript:;" data-rel="tab_2">Create a Seller
                                                            Account</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="auth_tab_wrap">
                                    <div class="auth_tab_content">
                                        <div id="tab_1" class="auth_content_inner form__wrap">
                                            @include('auth.register-user')
                                        </div>
                                        <div id="tab_2" class="auth_content_inner form__wrap">
                                            @include('auth.register-seller')
                                        </div>
                                        @if (count($errors) > 0)
                                            <div class="form__wrap auth_form_error alert alert-danger">
                                                <strong>Whoops!</strong> There were some problems with your
                                                input.<br><br>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @include('front.layouts.app-footer')
    </div>
@endsection
