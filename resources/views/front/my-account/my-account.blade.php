@extends('front.layouts.app')

@section('content')
@include('front.layouts.app-header')
<div id="content" class="main-content">
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="{{ url('/') }}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a></li>
                            <li>My Account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="user_profile_sec card_section">
        <div class="container">
            <div class="row">
                @include('front.my-account.left-sidebar')
                <div class="col col-9">
                    <div class="card user_profile_wrap">
                        <div class="card_title">
                            <h2>My Profile</h2>
                        </div>
                        <div class="user_ptofile_details">
                            <div class="user_profile_form">
                                <div class="user_profile_form_step">
                                    <div class="user_profile_step_title">About You</div>
                                    <form action="{{ route('user-details-update') }}" method="post" enctype="multipart/form-data" data-parsley-validate="">
                                        @csrf
                                        <div class="form__row row">
                                            <div class="input__filed col col-12">
                                                <div class="user_profile_img_wrap">
                                                    @if(!empty($user->image) && \Illuminate\Support\Facades\Storage::exists($user->image))
                                                    <img id="preview" class="profile_image_thumb" id="bannerImg" src="{{ url('storage') . '/' .  $user->image}}">
                                                    @else
                                                    <img id="preview" class="profile_image_thumb" src="images/no_profile.jpg" id="bannerImg" />
                                                    @endif
                                                    <div class="upload">
                                                        <div class="user_upload__button">
                                                            <p><i class="fa fa-upload" aria-hidden="true"></i> Upload Profile</p>
                                                            <input class="user_file_upload_upload choose" name="image" type="file" accept=".png, .jpg, .jpeg" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form__row row">
                                            <div class="input__filed col col-4">
                                                <label class="input__label">First Name</label>
                                                <input type="text" class="form-control" name="name" value="{{$user->name}}" required data-parsley-required-message="Name is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">Last Name</label>
                                                <input type="text" class="form-control" name="last_name" value="{{$user->last_name}}" required data-parsley-required-message="Last name is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">Your Email</label>
                                                <input type="email" class="form-control" name="email" value="{{$user->email}}" required data-parsley-required-message="Email is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-6">
                                                <label class="input__label">Street Address</label>
                                                <input type="text" class="form-control" name="address_line1" value="{{$user->addressFirst->address_line1}}" required data-parsley-required-message="Address is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-6">
                                                <label class="input__label">Apt, Suite, etc.,</label>
                                                <input type="text" class="form-control" name="address_line2" value="{{$user->addressFirst->address_line2}}">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">City</label>
                                                <input type="text" class="form-control" name="city" value="{{$user->addressFirst->city}}" required data-parsley-required-message="City is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">State</label>
                                                <input type="text" class="form-control" name="state" value="{{$user->addressFirst->state}}" required data-parsley-required-message="State is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">Zipcode</label>
                                                <input type="text" class="form-control" name="zipcode" value="{{$user->addressFirst->zipcode}}" required data-parsley-required-message="Zipcode  is required">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">Country</label>
                                                <select class="form-control" name="country_id" data-parsley-required-message="Country is required" required>
                                                    <option value="">Select Country</option>
                                                    @foreach($countries as $country)
                                                        <option value="{{ $country->id }}" {{($country->id == old('country_id', $user->addressFirst->country_id)) ? 'selected': '' }}>{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-2">
                                                <label class="input__label">Phone Number</label>
                                                <select name="phone_number_type" id="phone_number_type" class="form-control" required data-parsley-required-message="Phone Number Type is required">
                                                    <option value="Mobile" {{old('phone_number_type', $user->addressFirst->phone_number_type) == 'Mobile'? 'Selected': ''}}>Mobile</option>
                                                    <option value="Home" {{old('phone_number_type', $user->addressFirst->phone_number_type) == 'Home'? 'Selected': ''}}>Home</option>
                                                    <option value="Business" {{old('phone_number_type', $user->addressFirst->phone_number_type) == 'Business'? 'Selected': ''}}>Business</option>
                                                </select>
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-4">
                                                <label class="input__label">Phone Number</label>
                                                <input type="tel" class="form-control" required data-parsley-required-message="Phone Number is required" name="phone_number" value="{{$user->addressFirst->phone_number}}">
                                                <span class="error">Error</span>
                                            </div>
                                            <div class="input__filed col col-6">
                                                <label class="input__label">Date of Birth</label>
                                                <input type="date" class="form-control" name="birth_date" value="{{ $user->birth_date }}" required data-parsley-required-message="Birth Date is required">
                                                <span class="error">Error</span>
                                            </div>
                                        </div>
                                        <div class="form__row row">
                                            <div class="col col-12">
                                                <div class="btn">
                                                    <input type="submit" value="Save Changes">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="divider_line"></div>

                                <div class="user_profile_form_step">
                                    <div class="user_profile_step_title">Change Password</div>
                                    <form action="{{ route('my-account/password') }}" data-parsley-validate="" method="post" autocomplete="off">
                                        @csrf
                                        @method('put')
                                        @if (session('not_allow_password'))
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            {{ session('not_allow_password') }}
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        @endif
                                        <div class="form__row row">
                                            <div class="input__filed col col-4 form-group">
                                                <label class="input__label" for="input-current-password">{{ __('Current Password') }}</label>
                                                <input type="password" name="old_password" id="input-current-password" class="form-control" placeholder="{{ __('Current Password') }}" value="" required>
                                                @if ($errors->has('old_password'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('old_password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="input__filed col col-4 form-group">
                                                <label class="input__label" for="input-password">{{ __('New Password') }}</label>
                                                <input type="password" name="password" id="input-password" class="form-control" placeholder="{{ __('New Password') }}" value="" required>
                                                @if ($errors->has('password'))
                                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                                        <strong>{{ $errors->first('password') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="input__filed col col-4 form-group">
                                                <label class="input__label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                                <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control" placeholder="{{ __('Confirm New Password') }}" value="" required data-parsley-required-message="Please re-enter your new password." data-parsley-equalto="#input-password">
                                            </div>
                                        </div>
                                        <div class="form__row row">
                                            <div class="col col-12">
                                                <div class="btn">
                                                    <input type="submit" value="Update Password">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@include('front.layouts.app-footer')
@endsection
