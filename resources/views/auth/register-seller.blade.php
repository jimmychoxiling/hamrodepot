<form action="{{ route('register-seller') }}" method="post" enctype="multipart/form-data"  data-parsley-validate="">
    @csrf
    <div class="fomt__inner">
        <div class="form__step">
            <div class="form__title ">
                <h3>Sign up as a Seller account</h3>
                <p>Create a new online account and join Rewards or link accounts (joining or linking is optional).</p>
            </div>
            <div class="form__row row">
                <div class="input__filed col col-4">
                    <label class="input__label">First Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required data-parsley-required-message="First Name is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Last Name</label>
                    <input type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required data-parsley-required-message="Last Name is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Your Email</label>
                    <input type="email" class="form-control"  name="email" required data-parsley-required-message="Email Address is required"/>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Your Password</label>
                    <input type="password" class="form-control" name="password" id="password1" required data-parsley-required-message="Password is required"/>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmed" required
                           data-parsley-required-message="Please re-enter your new password."
                           data-parsley-equalto="#password1"/>
                    <span class="error">Error</span>
                </div>
            </div>
        </div>
        <div class="form__step">
            <div class="form__row row">
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
                <div class="input__filed col col-4">
                    <label class="input__label">Select Your Gender</label>
                    <select name="gender" id="gender" class="form-control" data-parsley-required-message="Gender is required" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-4">
                    <label class="input__label">Store/Company/Business Name </label>
                    <input type="text" class="form-control" name="business_name" required data-parsley-required-message="Business Name is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-12">
                    <label class="input__label">Address Line 1</label>
                    <input type="text" class="form-control" name="address_line1" required data-parsley-required-message="Address Line 1 is required"/>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-12">
                    <label class="input__label">Address Line 2</label>
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
                    <label class="input__label">Phone Number</label>
                    <input type="tel" id="phone" class="form-control" name="phone_number" required data-parsley-required-message="Phone Number is required">
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Number of Product you plan to list</label>
                    <select name="product_plan_to_list"  class="form-control" required data-parsley-required-message="Number of Product list is required">
                        <option value="">Select Product you plan to list</option>
                        <option value="1 to 10">1 to 10</option>
                        <option value="10 to 20">10 to 20</option>
                    </select>
                    <span class="error">Error</span>
                </div>
                <div class="input__filed col col-6">
                    <label class="input__label">Shipping method</label>
                    <div class="radio__wrap">
                        <div class="radio_box">
                            <input type="radio" name="shipping_method" id="radio1" value="Ship Yourself" required data-parsley-required-message="Shipping Method is required"/>
                            <label for="radio1">Ship Yourself</label>
                        </div>
                        <div class="radio_box">
                            <input type="radio" name="shipping_method" id="radio2" value="Shipment Done By Marketplace"/>
                            <label for="radio2">Shipment Done By Marketplace</label>
                        </div>
                    </div>
                    <span class="error">Error</span>
                </div>
            </div>
        </div>
    </div>
    <div class="form__row row">
        <div class="input__label check_box col col-12">
            <input type="checkbox" name="i_agree" id="Agree" value="1" required >
            <label for="Agree">I Agree Terms and Condition of marketplace</label>
        </div>
    </div>
    <div class="form__row row">
        <div class="submit__form btn col col-6 mx-auto">
            <input type="submit" value="Sign Up">
        </div>
    </div>
    <div class="form__row ">
        <div class="sign_in_out">
            <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
        </div>
    </div>
</form>
