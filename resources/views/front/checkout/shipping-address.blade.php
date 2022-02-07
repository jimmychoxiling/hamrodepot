<div class="checkout_address_item">
    <input type="radio" name="SelectAddress" id="shipping_id"  value="{{ $shipping_address_val->id }}" @if($shipping_address_val->default_address == '1') checked @endif>
    <div class="radio_wrap"></div>
    <div class="checkout_address_info">
        <div class="checkout_address_user_name">
            <h4 class="checkout_user_name">{{ $shipping_address_val->name }} {{ $shipping_address_val->last_name }}</h4>
            <label class="checkout_user_mobile">{{ $shipping_address_val->phone_number }}</label>
            <a href="javascript:;"  class="checkout_remove_address delete" data-tooltip="Remove" href="javascript:void(0);"
               data-href="{{route('shipping-address-delete', $shipping_address_val->id) }}"><i class="fa fa-times" aria-hidden="true"></i></a>
            @if($shipping_address_val->address_type == '1')
                <span><i class="fa fa-home" aria-hidden="true"></i> Home</span>
            @else
                <span><i class="fa fa-briefcase" aria-hidden="true"></i> Work</span>
            @endif
        </div>
        <div class="checkout_address_name">
            <label for="">
                {{$shipping_address_val->address_line1}},
                @if($shipping_address_val->address_line2 != '')
                    {{$shipping_address_val->address_line2}},
                @endif
                {{$shipping_address_val->city}},
                {{ $shipping_address_val->state }},
                {{ $shipping_address_val->country->name }} - {{ $shipping_address_val->zipcode }}
            </label>
        </div>
        <div class="checkout_address_deliver_btn">
            <ul>
                <li class="btn"><a data-fancybox="" href="javascript:;" data-src="#CheckoutAddressPopup" class="editAddress" data-id="{{ $shipping_address_val->id }}">Edit Address</a></li>
                <li class="btn"><a href="javascript:;">Deliver to this address</a></li>
            </ul>
        </div>
    </div>
</div>

