<form action="{{ route('register-user') }}" method="post" enctype="multipart/form-data"  data-parsley-validate="">
    @csrf
    <div class="fomt__inner">
        <div class="form__step">
            <div class="form__title ">
                <h3>Create an account </h3>
                <p>Create a new online account and join Rewards or link accounts (joining or linking is optional).</p>
            </div>
            <div class="form__row row">
                <div class="input__filed col col-4">
                    <label class="input__label">Your Email</label>
                    <input type="email" class="form-control"  name="email" required data-parsley-required-message="Email Address is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Your Password</label>
                    <input type="password" class="form-control" name="password" id="password" required data-parsley-required-message="Password is required"/>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmed" required
                           data-parsley-required-message="Please re-enter your new password."
                           data-parsley-equalto="#password"/>
                </div>
            </div>
        </div>
        <div class="form__step">
            <label for="" class="step__info">About you</label>
            <div class="form__row row">
                <div class="input__filed col col-6">
                    <label class="input__label">First Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required data-parsley-required-message="First Name is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required data-parsley-required-message="Last Name is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Street Address</label>
                    <input type="text" class="form-control" name="address_line1" required data-parsley-required-message="Address is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Apt, Suite, etc.,</label>
                    <input type="text" class="form-control" name="address_line2"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">State</label>
                    <input type="text" class="form-control" name="state" required data-parsley-required-message="State is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">City</label>
                    <input type="text" class="form-control" name="city" required data-parsley-required-message="City is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Postal/ZipCode</label>
                    <input type="text" class="form-control" name="zipcode" required data-parsley-required-message="Zipcode is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Select Country</label>
                    <select class="form-control" name="country_id" data-parsley-required-message="Country is required" required>
                        <option value="">Select Country</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-2">
                    <label class="input__label">Phone Number</label>
                    <select name="phone_number_type"  class="form-control" required data-parsley-required-message="Phone Number Type is required">
                        <option value="Mobile">Mobile</option>
                        <option value="Home">Home</option>
                        <option value="Business">Business</option>
                    </select>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Phone Number</label>
                    <input type="tel" id="phone" class="form-control" name="phone_number" required data-parsley-required-message="Phone Number is required">
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Date of Birth</label>
                    <input type="date" id="birth_date" class="form-control" name="birth_date" required data-parsley-required-message="Birth Date is required">
                    <span class="error">Error</span>
                </div>
            </div>
        </div>
        <div class="form__row row">
            <div class="input__label check_box col col-12">
                <input type="checkbox" name="i_agree"  id="Agree" value="1">
                <label for="Agree">I confirm I have read and agree to the hamro depot Program Terms, Privacy Policy and Terms of Use.</label>
            </div>
        </div>
        <div class="form__row row">
            <div class="submit__form btn col col-6 mx-auto">
                <input type="submit" value="Sign Up">
            </div>
        </div>
        <div class="form__row ">
            <div class="sign_in_out">
                <p>Already have an account? <a href="javascript:;">Sign in</a></p>
            </div>
        </div>
    </div>
</form>
