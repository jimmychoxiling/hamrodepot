@extends('front.layouts.app')
@section('content')
    <div id="page-wrapper">
        @include('front.layouts.register-login-header')
        <div id="content" class="main-content">
            <section class="authentication__sec forgot_password"
                     style="background: url('{{ asset('images/banner.png') }}')  center / cover fixed;">
                <div class="container full-width">
                    <div class="row">
                        <div class="col col-6">
                        </div>
                        <div class="col col-6">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @if (session('info'))
                                <div class="alert alert-info" role="alert">
                                    {{ session('info') }}
                                </div>
                            @endif
                            <div class="form_main_wrapper">
                                <div class="form__wrap">
                                    <div class="form__title">
                                        <a href="{{ route('login') }}" class="back_to_home"><i
                                                class="fa fa-long-arrow-left"
                                                aria-hidden="true"></i>Back to Log
                                            in</a>
                                        <h3>Forgot Your Password</h3>
                                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quo, eius.</p>
                                    </div>

                                    <form role="form" method="POST" action="{{ route('password.email') }}"
                                          data-parsley-validate="">
                                        @csrf
                                        <div class="fomt__inner">
                                            <div class="form__row">
                                                <div class="input__filed">
                                                    <label class="input__label">Your Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                           placeholder="Enter your email address"
                                                           value="{{ old('email') }}" autofocus required
                                                           data-parsley-required-message="Email Address is required"/>
                                                    <span class="error">Error</span>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form__row">
                                                <div class="submit__form btn">
                                                    <input type="submit" value="Send Link">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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
