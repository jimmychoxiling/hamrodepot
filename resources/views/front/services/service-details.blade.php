@extends('front.layouts.app')
@section('content')
@include('front.layouts.app-header')
<div class="c_popup_wrapper" id="BookSlotModal">
    <div class="c_popup_overlay"></div>
    <div class="c_popup_inner">
        <div class="c_popup_close close_from"><i class="fa fa-times" aria-hidden="true"></i></div>
        <div class="c_popup_header d-none">
            <h4 class="c_popup_title">John Doe <span>(Small Kitchen Appliances)</span></h4>
        </div>
        <div class="c_popup_body">
            <form   action="{{ route('save-service-request') }}" method="POST" data-parsley-validate="" class="service-request-form">
                @csrf
                <input type="hidden" name="service_id" class="form-control service_id" value="" >
                <div class="form_wrapper">
                    <div class="row">
                        <div class="col col-4">
                            <h3 class="booking_title">Booking Details</h3>
                            <div class="row">
                                <div class="input__filed col col-12">
                                    <label class="input__label">Select Date</label>
                                    <input type="date" class="form-control" name="service_date" required="" data-parsley-required-message="Date is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-12">
                                    <label class="input__label">Service Information</label>
                                    <textarea name="description" id="" rows="5" class="form-control" ></textarea>
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-12">
                                    <label class="input__label">Select Time</label>
                                    @foreach (config('constant.SERVICE_TIMING') as $tk => $time)
                                    <div class="c_check_box">
                                        <input type="checkbox" name="time[]" id="" value="{{$tk}}" required="" data-parsley-required-message="Time is required">
                                        <label for="">{{ $time }}</label>
                                    </div>
                                    @endforeach
                                    <span class="error">Error</span>
                                </div>
                                <!-- <div class="input__filed col col-12">
                                    <label class="input__label">Budget</label>
                                    <input type="text" class="form-control" name="budget" required="" data-parsley-required-message="Budget is required">
                                    <span class="error">Error</span>
                                </div> -->
                            </div>
                        </div>
                        <div class="col col-8">
                            <h3 class="booking_title">Presonal Details</h3>
                            <div class="row">
                                <div class="input__filed col col-6">
                                    <label class="input__label">First Name</label>
                                    <input type="text" class="form-control" name="first_name" required="" data-parsley-required-message="First Name is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">last Name</label>
                                    <input type="text" class="form-control" name="last_name" required="" data-parsley-required-message="Last Name is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">Email</label>
                                    <input type="email" class="form-control" name="email" required="" data-parsley-required-message="Email is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">Phone</label>
                                    <input type="text" class="form-control" name="phone" required="" data-parsley-required-message="Phone is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">City</label>
                                    <input type="text" class="form-control" name="city" required="" data-parsley-required-message="City is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">Zip Code</label>
                                    <input type="text" class="form-control" name="zipcode" required="" data-parsley-required-message="Zip code is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">State</label>
                                    <input type="text" class="form-control" name="state" required="" data-parsley-required-message="State is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-6">
                                    <label class="input__label">Country</label>
                                    <input type="text" class="form-control" name="country" required="" data-parsley-required-message="Country is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed col col-12">
                                    <label class="input__label">Address</label>
                                    <textarea name="address" id="address" rows="4" class="form-control"></textarea data-parsley-required-message="Address is required">
                                    <span class="error">Error</span>
                                </div>
                                <div class="input__filed btn col col-12">
                                    <input type="submit" value="Book Now" class="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="content" class="main-content">
    <section class="breadcrumb_section">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="breadcrumb">
                        <ul>
                            <li><a href="{{route('service')}}"><i class="fa fa-long-arrow-left" aria-hidden="true"></i>Back</a>
                            </li>
                            <li>
                                <a href="{{route('service')}}">Services</a>
                            </li>
                            <li>Find Services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="find_service_sec sub_category_product_sec">
        <div class="container">
            <div class="row">
                <div class="col col-12">
                    <div class="mian_list_content">
                            @if($services_count > 0)
                        <div class="sidebar" id="filter_sidebar">
                            <div class="sb_sub_category_wrap">
                                <h4 class="sb_sub_category_title active category_toggle">Categories <i class="fa fa-caret-up"
                                    aria-hidden="true"></i></h4>
                                <div class="sb_sub_category_list_wrap" style="">
                                    <ul class="sb_filter_list_wrap truncate">
                                        @foreach($serviceCategories as $serviceCategorie)
                                        <li class="sb_filter_item">
                                            <input type="checkbox" name="filter_category" {{ ($serviceCategorie->slug == $slug ? 'checked' : '')}} class="side_filter"  value="{{$serviceCategorie->id}}">
                                            <label for="" class="sb_category_text" >{{$serviceCategorie->name}}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="sb_sub_category_wrap">
                                <h4 class="sb_sub_category_title active">Time Slot <i class="fa fa-caret-up"
                                    aria-hidden="true"></i></h4>
                                <div class="sb_sub_category_list_wrap" style="">
                                    <ul class="sb_filter_list_wrap truncate">
                                        @foreach (config('constant.SERVICE_TIMING') as $tk => $time)
                                        <li class="sb_filter_item">
                                            <input type="checkbox"  name="filter_time" class="side_filter" value="{{$tk}}">
                                            <label for="" class="sb_category_text">{{ $time }}</label>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="sb_sub_category_wrap ">
                                <h4 class="sb_sub_category_title active">Price <i class="fa fa-caret-up"
                                    aria-hidden="true"></i></h4>
                                <div class="sb_sub_category_list_wrap" style="">
                                    <ul class=" truncate">
                                        <div id="rangeSlider" class="range-slider">
                                            <div class="number-group ">
                                                <div class="input__wrap">
                                                    <input class="number-input" type="number" name="min_price" value="0" min="0" max="{{ $max_amount }}" />
                                                    <span>$</span>
                                                </div>
                                                <span>to</span>
                                                <div class="input__wrap ">
                                                    <input class="number-input" type="number" name="max_price" value="{{ $max_amount }}" min="0"
                                                        max="{{ $max_amount }}" />
                                                    <span>$</span>
                                                </div>
                                            </div>
                                            <div class="range-group side_filter">
                                                <input class="range-input " value="0" min="0" max="{{ $max_amount }}" step="1" type="range"
                                                    id="min_price" />
                                                <input class="range-input" value="{{ $max_amount }}" min="0" max="{{ $max_amount }}" step="1"
                                                    type="range" id="max_price" />
                                            </div>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="service_list_wrap find_service_list_wrap ">
                        <div class="find_service_list_wrap side_filter_data d-none">
                        </div>
                             @include('front.services.no-service')
                            <div class="page_data">
                                @include('front.services.services-list')
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="d-none mobile_filter_button">
            <a href="javascript:;" class="filter_btn"><i class="fa fa-filter" aria-hidden="true"></i> Filter</a>
            <a href="javascript:;" class="filter_cancel_btn d-none"><i class="fa fa-times" aria-hidden="true"></i>
            Close</a>
        </div>
    </section>
</div>
@include('front.layouts.app-footer')
@endsection
@section('extra-js')
<script>
    $(document).on('click', '.select_service', function() {
        var service_id = $(this).attr('data-id');
        $('.service_id').val(service_id);
    });
    var cat_ids = [];
    var time_ids = [];
    
    var checked_cat = $('input[name="filter_category"]:checked').val();
    cat_ids.push(checked_cat);

    $('.close_from').click(function (){
        $('.service-request-form').parsley().reset();
    });
    $(".side_filter").click(function(){
        
    $('.service_list_wrap').addClass('section-loader');
    $('.side_filter_data').html("");
    $('.page_data').html("");
    var max_price = $('input[name="max_price"]').val();
    var min_price = $('input[name="min_price"]').val();

    cat_ids = $.map($("input:checkbox[name=filter_category]:checked"), function(a) { return a.value; })
   
    time_ids = $.map($("input:checkbox[name=filter_time]:checked"), function(a) { return a.value; })
    
    $.ajax({
           type:'POST',
           url:"{{ route('services-filter') }}",
           data:{cat_ids:cat_ids,time_ids:time_ids,max_price:max_price,min_price:min_price},
           success:function(data){
               if(data.services_count  > 0){
                $('.service_list_wrap').removeClass('section-loader');
                $('.side_filter_data').show();
                $('.page_data').hide();
                $("#no_service_section").css({'display':'none'}); 
                $('.side_filter_data').html(data.html);
               }else if(data.services_count == 0 || !data.services_count){
                $('.service_list_wrap').removeClass('section-loader');
                $('.side_filter_data').hide();             
                $('.page_data').hide();
                $(".no_data_error").css("display","");
               }
            
           }
        });
    });
</script>
@endsection