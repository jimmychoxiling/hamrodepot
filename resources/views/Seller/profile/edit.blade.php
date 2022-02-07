 <div class="container-fluid mt--7">
     <div class="row">

         <div class="col-xl-12 order-xl-1">
             <div class="card bg-secondary shadow">
                 <div class="card-header bg-white border-0">
                     <div class="row align-items-center">
                         <h3 class="mb-0">{{ __('Edit Profile') }}</h3>
                     </div>
                 </div>
                 <div class="card-body">
                     <form method="post" action="{{ route('seller-profile.update') }}" enctype="multipart/form-data" autocomplete="off" data-parsley-validate="">
                         @csrf
                         @method('put')

                         <h6 class="heading-small text-muted mb-4">{{ __('User information') }}</h6>

                         @if (session('status'))
                         <div class="alert alert-success alert-dismissible fade show" role="alert">
                             {{ session('status') }}
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         @endif


                         <div class="pl-lg-4 row">
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-name">{{ __('Name') }}</label>
                                     <input type="text" name="name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}" required autofocus>

                                     @if ($errors->has('name'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('name') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('last_name') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-name">{{ __('Last Name') }}</label>
                                     <input type="text" name="last_name" id="input-name" class="form-control form-control-alternative{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->last_name) }}" required>

                                     @if ($errors->has('last_name'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('last_name') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-email">{{ __('Email') }}</label>
                                     <input type="email" name="email" id="input-email" class="form-control form-control-alternative{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required>
                                     @if ($errors->has('email'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('email') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('country_id') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-country_id">{{ __('Country') }}</label>
                                     <select class="form-control" name="country_id" required>
                                         <option value="">Select Country</option>
                                         @foreach($countries as $country)
                                         <option value="{{ $country->id }}" {{ (old('country_id', auth()->user()->country_id) == $country->id) ? 'selected': '' }}>{{ $country->name }}</option>
                                         @endforeach
                                     </select>
                                     @if ($errors->has('country_id'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('country_id') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('gender') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-gender">{{ __('Gender') }}</label>
                                     <select name="gender" id="gender" class="form-control" required>
                                         <option value="">Select Gender</option>
                                         <option value="Male" {{ (old('gender', auth()->user()->gender) == 'Male') ? 'selected': '' }}>Male</option>
                                         <option value="Female" {{ (old('gender', auth()->user()->gender) == 'Female') ? 'selected': '' }}>Female</option>
                                         <option value="Other" {{ (old('gender', auth()->user()->gender) == 'Other') ? 'selected': '' }}>Other</option>
                                     </select>
                                     @if ($errors->has('gender'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('gender') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('business_name') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-business_name">{{ __('Store/Company/Business Name') }}</label>
                                     <input type="text" class="form-control" name="business_name" required value="{{ old('business_name', auth()->user()->business_name) }}" />
                                     @if ($errors->has('business_name'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('business_name') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">

                                 <div class="form-group{{ $errors->has('address_line1') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-address_line1">{{ __('Address 1') }}</label>
                                     <input type="text" class="form-control" name="address_line1" required value="{{ old('address_line1', auth()->user()->address_line1) }}" />
                                     @if ($errors->has('address_line1'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('address_line1') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('address_line2') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-address_line2">{{ __('Address 2') }}</label>
                                     <input type="text" class="form-control" name="address_line2" value="{{ old('address_line2', auth()->user()->address_line2) }}" />
                                     @if ($errors->has('address_line2'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('address_line2') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-state">{{ __('State') }}</label>
                                     <input type="text" class="form-control" name="state" required value="{{ old('state', auth()->user()->state) }}" />
                                     @if ($errors->has('state'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('state') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-city">{{ __('City') }}</label>
                                     <input type="text" class="form-control" name="city" required value="{{ old('city', auth()->user()->city) }}" />
                                     @if ($errors->has('city'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('city') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">

                                 <div class="form-group{{ $errors->has('zipcode') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-zipcode">{{ __('Postal/ZipCode') }}</label>
                                     <input type="text" class="form-control" name="zipcode" required value="{{ old('zipcode', auth()->user()->zipcode) }}" />
                                     @if ($errors->has('zipcode'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('zipcode') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-phone">{{ __('Phone') }}</label>
                                     <input type="tel" id="phone" class="form-control" name="phone_number" required value="{{ old('phone', auth()->user()->phone_number) }}">
                                     @if ($errors->has('phone'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('phone') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('product_plan_to_list') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-product_plan_to_list">{{ __('Number of Product you plan to list') }}</label>
                                     <select name="product_plan_to_list" class="form-control" required>
                                         <option value="">Select Product you plan to list</option>
                                         <option value="1 to 10" {{(old('product_plan_to_list', auth()->user()->product_plan_to_list) == '1 to 10' ? 'selected': '' )}}>1 to 10</option>
                                         <option value="10 to 20" {{(old('product_plan_to_list', auth()->user()->product_plan_to_list) == '10 to 20' ? 'selected': '' )}}>10 to 20</option>
                                     </select>
                                     @if ($errors->has('product_plan_to_list'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('product_plan_to_list') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-6">
                                 <div class="form-group{{ $errors->has('shipping_method') ? ' has-danger' : '' }}">
                                     <label class="form-control-label" for="input-shipping_method">{{ __('Number of Product you plan to list') }}</label>
                                     <div class="radio__wrap">
                                         <div class="radio_box">
                                             <input type="radio" name="shipping_method" id="radio1" {{(old('shipping_method', auth()->user()->shipping_method) == 'Ship Yourself' ? 'checked':'')}} value="Ship Yourself" required data-parsley-required-message="Shipping Method is required" />
                                             <label for="radio1">Ship Yourself</label>
                                         </div>
                                         <div class="radio_box">
                                             <input type="radio" name="shipping_method" id="radio2" {{(old('shipping_method', auth()->user()->shipping_method) == 'Shipment Done By Marketplace' ? 'checked':'')}} value="Shipment Done By Marketplace" />
                                             <label for="radio2">Shipment Done By Marketplace</label>
                                         </div>
                                     </div>
                                     @if ($errors->has('shipping_method'))
                                     <span class="invalid-feedback" role="alert">
                                         <strong>{{ $errors->first('shipping_method') }}</strong>
                                     </span>
                                     @endif
                                 </div>
                             </div>
                             <div class="col-md-3">
                                 <div class="form-group">
                                     <label class="form-control-label" for="input-image">Profile Image</label>
                                     <div class="profile-icon">

                                         @if(!empty(auth()->user()->image) && \Illuminate\Support\Facades\Storage::exists(auth()->user()->image))
                                         <img class='img-responsive' id="uploadPreview1" src="{{ url('storage') . '/' .  auth()->user()->image}}" style="height: 150px;">
                                         @else
                                         <img class='img-responsive' id="uploadPreview1" src="{{ url('storage/no_image.png')}}" style="height: 150px;">
                                         @endif
                                     </div>
                                     <div class="m-b-10">
                                         <input type="file" accept="image/x-png, image/gif, image/jpeg" id="uploadImage1" class="btn btn-block btn-sm" name="image" onChange="this.parentNode.nextSibling.value = this.value; PreviewImage(1);">
                                     </div>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <div class="text-center">
                                     <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                                 </div>
                             </div>
                         </div>
                     </form>

                     <!-- Seller Timing form start-->
                     <hr class="my-4" />

                     <form method="post" action="{{route('seller-profile.updateHours')}}" autocomplete="off">
                         @csrf
                         @method('put')
                         <h6 class="heading-small text-muted mb-4">{{ __('Opening Hours') }}</h6>
                         <div class="table-responsive">
                             <table class="table align-items-center table-flush yajra-datatable" id="hours-datatable">
                                 <thead class="thead-light">
                                     <tr>
                                         <th scope="col">Day</th>
                                         <th scope="col">Is Open</th>
                                         <th scope="col">Opening Time</th>
                                         <th scope="col">Closing Time</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach($hours as $key=>$hour)
                                     <tr>
                                         <td>{{$hour->day}}
                                             <input type="hidden" name="id[]" class="form-control" id="id{{$key}}" value="{{ old('id', $hour->id) }}">
                                             <input type="hidden" name="day[]" class="form-control" id="day{{$key}}" value="{{ old('day', $hour->day) }}">
                                         </td>
                                         <td class="isOpenDay" data-value="{{$hour->isOpen}}">
                                             <div class="form-group">
                                                 <div class="checkbox_wrapper">
                                                     <input type="checkbox" name="isOpen{{$key}}" class="form-control open-check" id="isOpen{{$key}}" {{$hour->isOpen == '1' ? 'Checked': ''}}>
                                                <label></label>
                                                 </div>
                                             </div>
                                         </td>
                                         <td class="{{$hour->isOpen == 1 ? '': 'isShowTime'}}">
                                             <div class="form-group seller_time_div">
                                                 <input type="time" name="opening_time[]" id="opening_hour{{$key}}" class="form-control" value="{{ old('opening_time', $hour->opening_time) }}" required>
                                             </div>
                                         </td>
                                         <td class="{{$hour->isOpen == 1 ? '': 'isShowTime'}}">
                                             <div class="form-group ">
                                                 <input type="time" name="closing_time[]" id="closing_hour{{$key}}" class="form-control " value="{{ old('closing_time', $hour->closing_time) }}" required>
                                             </div>
                                         </td>
                                     </tr>
                                     @endforeach
                                 </tbody>

                             </table>
                         </div>
                         <div class="text-center">
                             <button type="submit" class="btn btn-success mt-4">{{ __('Save') }}</button>
                         </div>
                     </form>
                     <!-- Seller Timing form end-->

                     <hr class="my-4" />
                     <form method="post" action="{{ route('seller-profile.password') }}" autocomplete="off">
                         @csrf
                         @method('put')

                         <h6 class="heading-small text-muted mb-4">{{ __('Password') }}</h6>

                         @if (session('password_status'))
                         <div class="alert alert-success alert-dismissible fade show" role="alert">
                             {{ session('password_status') }}
                             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                 <span aria-hidden="true">&times;</span>
                             </button>
                         </div>
                         @endif

                         <div class="pl-lg-4">
                             <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                                 <label class="form-control-label" for="input-current-password">{{ __('Current Password') }}</label>
                                 <input type="password" name="old_password" id="input-current-password" class="form-control form-control-alternative{{ $errors->has('old_password') ? ' is-invalid' : '' }}" placeholder="{{ __('Current Password') }}" value="" required>

                                 @if ($errors->has('old_password'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('old_password') }}</strong>
                                 </span>
                                 @endif
                             </div>
                             <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                 <label class="form-control-label" for="input-password">{{ __('New Password') }}</label>
                                 <input type="password" name="password" id="input-password" class="form-control form-control-alternative{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ __('New Password') }}" value="" required>

                                 @if ($errors->has('password'))
                                 <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('password') }}</strong>
                                 </span>
                                 @endif
                             </div>
                             <div class="form-group">
                                 <label class="form-control-label" for="input-password-confirmation">{{ __('Confirm New Password') }}</label>
                                 <input type="password" name="password_confirmation" id="input-password-confirmation" class="form-control form-control-alternative" placeholder="{{ __('Confirm New Password') }}" value="" required>
                             </div>

                             <div class="text-center">
                                 <button type="submit" class="btn btn-success mt-4">{{ __('Change password') }}</button>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     @section('extra-js')
     <script>
         $(".open-check").click(function() {
             const value = $(this).is(":checked");
             if (value) {
                 $(this).closest('td').nextUntil().removeClass('isShowTime');
             } else {
                 $(this).closest('td').nextUntil().addClass('isShowTime');
             }
             // $(this).nextAll().slideToggle('slow');
         });
     </script>
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