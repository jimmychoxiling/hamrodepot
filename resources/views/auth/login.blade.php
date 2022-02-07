@extends('front.layouts.app')
@section('content')
    <div id="page-wrapper">
        @include('front.layouts.register-login-header')
        <div id="content" class="main-content">
            <section class="authentication__sec login"
                     style="background: url('{{ asset('images/banner.png') }}')  center / cover fixed;">
                <div class="container full-width">
                    <div class="row">
                        <div class="col col-6">
                            <!-- <div class="img authentication_banner" style="background: url(images/authentication_banner.jpg)  center / cover;"></div> -->
                        </div>
                        <div class="col col-6">
                            <div class="form_main_wrapper">
                                <div class="form__wrap">
                                    <div class="form__title">
                                        <a href="{{ url('/') }}" class="back_to_home"><i class="fa fa-long-arrow-left"
                                                                                         aria-hidden="true"></i>Back to
                                            Home</a>
                                        <h3>Login</h3>
                                        <p>Sign in to access your account and Rewards.</p>
                                    </div>
                                    <form role="form" method="POST" action="{{ route('login') }}"
                                          data-parsley-validate="">
                                        @csrf
                                        <div class="fomt__inner">
                                            <div class="form__row">
                                                <div class="input__filed">
                                                    <label class="input__label">Your Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                           placeholder="Enter your email address"
                                                           value="{{ old('email') }}" class="form-control" autofocus
                                                           required
                                                           data-parsley-required-message="Email Address is required"/>
                                                    <span class="error">Error</span>
                                                    @if ($errors->has('email'))
                                                        <span class="invalid-feedback" style="display: block;"
                                                              role="alert">
                                                            <strong>{{ $errors->first('email') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="input__filed">
                                                    <label class="input__label">Your Password</label>
                                                    <input class="form-control" type="password" name="password"
                                                           placeholder="Enter your password" required
                                                           data-parsley-required-message="Password is required"/>
                                                    <span class="error">Error</span>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" style="display: block;"
                                                              role="alert">
                                                            <strong>{{ $errors->first('password') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form__row">
                                                <div class="forgot__pswd">
                                                    <a href="{{ route('password.request') }}">Forgot password ?</a>
                                                </div>
                                            </div>
                                            <div class="form__row">
                                                <div class="submit__form btn">
                                                    <input type="submit" value="Login">
                                                </div>
                                            </div>
                                            <div class="form__row ">
                                                <div class="sign_in_out">
                                                    <p>Don't have an account? <a href="{{ route('register') }}">Join</a>
                                                    </p>
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
