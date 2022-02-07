@extends('Backend.layouts.app', ['title' => __('Seller')])

@section('content')


<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('seller') }}">Seller</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$seller->id ? 'update' : 'Add'}} Seller</li>
                        </ol>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Page content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <h3 class="mb-0">
                            {{$seller->id ? 'update' : 'Add'}} Seller
                        </h3>
                    </div>
                </div>
                <div class="card-body">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <form method="post" action="{{ route($url, $seller->id ?['id' => $seller->id]: []) }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">First Name</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="First Name" value="{{ old('name', $seller->name) }}" required autofocus data-parsley-required-message="First Name is required">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-last_name">Last Name</label>
                                        <input type="text" name="last_name" id="input-last_name" class="form-control form-control-alternative" placeholder="Last Name" value="{{ old('last_name', $seller->last_name) }}" required autofocus data-parsley-required-message="Last Name is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Email</label>
                                        <input type="email" name="email" id="input-name" class="form-control form-control-alternative" placeholder="Email" value="{{ old('email', $seller->email) }}" required autofocus data-parsley-required-message="Email is required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-business_name">Business Name</label>
                                        <input type="text" name="business_name" id="input-business_name" class="form-control form-control-alternative" placeholder="Business Name" value="{{ old('business_name', $seller->business_name) }}" required autofocus data-parsley-required-message="Business Name is required">
                                    </div>
                                </div>
                                @if(empty($seller->id))
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Password</label>
                                        <input type="password" name="password" id="input-password" class="form-control form-control-alternative" placeholder="Password" value="{{ old('password', $seller->password) }}" required data-parsley-required-message="Password is required">
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address-1">Address 1</label>
                                        <textarea name="address_line1" id="input-address-1" class="form-control form-control-alternative" placeholder="Address" required data-parsley-required-message="Address 1 is required">{{ old('address_line1', $seller->address_line1) }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address-2">Address 2</label>
                                        <textarea name="address_line2" id="input-address-2" class="form-control form-control-alternative" placeholder="Address">{{ old('address_line2', $seller->address_line2) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-city">City</label>
                                        <input type="text" name="city" id="input-city" class="form-control form-control-alternative" placeholder="City" value="{{ old('city', $seller->city) }}" required data-parsley-required-message="City is required">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-zipcode">Zipcode</label>
                                        <input type="text" name="zipcode" id="input-zipcode" class="form-control form-control-alternative" placeholder="Zipcode" value="{{ old('zipcode', $seller->zipcode) }}" required data-parsley-required-message="Zipcode is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-phone">Phone</label>
                                        <input type="text" name="phone_number" id="input-phone_number" class="form-control form-control-alternative" placeholder="Phone Number" value="{{ old('phone_number', $seller->phone_number) }}" required data-parsley-required-message="Phone number is required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-countries_id">Country</label>
                                        <select name="country_id" class="form-control form-control-alternative" required data-parsley-required-message="Country is required">
                                            <option value="">Select Countries</option>
                                            @foreach($countries as $countries_val)
                                            <option value="{{$countries_val->id}}" {{($countries_val->id == old('country_id', $seller->country_id)) ? 'selected': '' }}>{{$countries_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-state">State</label>
                                        <input type="text" name="state" id="input-state" class="form-control form-control-alternative" placeholder="State" value="{{ old('state', $seller->state) }}" required data-parsley-required-message="State is required">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-control-label">Select Gender</label>
                                    <select name="gender" id="gender" class="form-control form-control-alternative" data-parsley-required-message="Gender is required" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{(old('gender', $seller->gender) == 'Male' ? 'selected':'')}}>Male</option>
                                        <option value="Female" {{(old('gender', $seller->gender) == 'Female' ? 'selected':'')}}>Female</option>
                                        <option value="Other" {{(old('gender', $seller->gender) == 'Other' ? 'selected':'')}}>Other</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Status</label>
                                        <select name="status" class="form-control form-control-alternative" required data-parsley-required-message="Status is required">
                                            <option value="1" {{(old('status', $seller->status) == '1' ? 'selected':'')}}>Active
                                            </option>
                                            <option value="2" {{(old('status', $seller->status) == '2' ? 'selected':'')}}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-product-plan">Number of Product you plan to list</label>
                                        <select name="product_plan_to_list" class="form-control form-control-alternative" required data-parsley-required-message="Product you plan to list is required">
                                            <option value="" selected disabled>Select Product you plan to list</option>
                                            <option value="1 to 10" {{(old('product_plan_to_list', $seller->product_plan_to_list) == '1 to 10' ? 'selected':'')}}>1 to 10</option>
                                            <option value="10 to 20" {{(old('product_plan_to_list', $seller->product_plan_to_list) == '10 to 20' ? 'selected':'')}}>10 to 20</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-control-label">Shipping method</label>
                                    <div class="radio__wrap">
                                        <div class="radio_box">
                                            <input type="radio" {{(old('shipping_method', $seller->shipping_method) == 'Ship Yourself' ? 'checked':'')}} name="shipping_method" id="radio1" value="Ship Yourself" required data-parsley-required-message="Shipping Method is required" />
                                            <label for="radio1">Ship Yourself</label>
                                        </div>
                                        <div class="radio_box">
                                            <input type="radio" {{(old('shipping_method', $seller->shipping_method) == 'Shipment Done By Marketplace' ? 'checked':'')}} name="shipping_method" id="radio2" value="Shipment Done By Marketplace" />
                                            <label for="radio2">Shipment Done By Marketplace</label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">{{$seller->id ? 'Update' : 'Add'}} </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @include('Backend.layouts.footers.auth')
</div>
@endsection

@section('extra-js')
<script>
    function PreviewImage(no) {
        var oFReader = new FileReader();
        oFReader.readAsDataURL(document.getElementById("uploadImage" + no).files[0]);
        oFReader.onload = function(oFREvent) {
            document.getElementById("uploadPreview" + no).src = oFREvent.target.result;
        };
    }
</script>
@endsection