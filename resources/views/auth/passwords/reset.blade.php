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
                            <div class="form_main_wrapper">
                                <div class="form__wrap">
                                    <div class="form__title">
                                        <a href="{{ route('login') }}" class="back_to_home"><i
                                                class="fa fa-long-arrow-left"
                                                aria-hidden="true"></i>Back to Log
                                            in</a>
                                        <h3>Reset Your Password</h3>
                                    </div>
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
                                    <form role="form" method="POST" action="{{ route('password.update') }}"
                                          data-parsley-validate="">
                                        @csrf
                                        <input type="hidden" name="token" value="{{ $token }}">
                                        <div class="fomt__inner">
                                            <div class="form__row">
                                                <div class="input__filed">
                                                    <label class="input__label"> Email</label>
                                                    <input class="form-control" type="email" name="email"
                                                           placeholder="Enter your email address"
                                                           value="{{ $email ?? old('email') }}" autofocus required
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
                                                <div class="input__filed">
                                                    <label class="input__label"> Password</label>
                                                    <input  class="form-control" type="password" name="password" id="password"
                                                           placeholder="Enter your password" required
                                                           data-parsley-required-message="Password is required">
                                                    <span class="error">Error</span>
                                                    @if ($errors->has('password'))
                                                        <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="form__row">
                                                <div class="input__filed">
                                                    <label class="input__label"> Confirm Password</label>
                                                    <input class="form-control" type="password" name="password_confirmation"
                                                           placeholder="Enter your Confirm password" required
                                                           data-parsley-required-message="Confirm Password is required"
                                                           data-parsley-equalto="#password">
                                                    <span class="error">Error</span>
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
