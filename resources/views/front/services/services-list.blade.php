@php
if(isset($services->service))
{
$services = $services->service;
}
@endphp
<div class="find_service_list_inner">
    @foreach($services as $service)
    @if($service->status == 1)
    <div class="find_service_item">
        <div class="find_service_seller_info">
            <label for="">{{$service->category->name}}</label>
            <div class="find_service_seller_img">
                @if(!empty($service->image) && \Illuminate\Support\Facades\Storage::exists($service->image))
                <img class='img-responsive' src="{{ asset('storage') . '/' .  $service->image}}" hight="100px"
                    width="100px">
                @else
                <img src="{{ asset('images/furniture.svg')}}" alt="">
                @endif
            </div>
            <div class="btn-price">
                <h4 class="find_service_seller_name">{{ config('constant.CURRENCY_SIGN') }} {{$service->price}}</h4>
                <p class="view_profile btn"><a href="javascript:;" class="red-btn select_service"  data-id="{{$service->id}}" data-toggle="modal" data-target="#BookSlotModal">Continue</a></p>
            </div>
        </div>
        <div class="find_service_seller_info_content">
            <div class="find_service_seller_desc">
                <h4 class="service-title">{{$service->name}}  </h4>
                <p> {{$service->description}}</p>
            </div>
            
            <div class="find_service_seller_desc find_service_seller_addresses">
                <h4>Seller : <span>{{$service->seller->name}} </span></h4>
            </div>
            <div class="find_service_seller_desc find_service_seller_addresses">
                <h5>Addresses</h5>
                <ul>
                
                    @if($service->time)
                    @foreach (config('constant.SERVICE_TIMING') as $tk => $time)
                        @if(in_array($tk,json_decode($service->time)))
                        <li><i class="fa fa-clock-o" aria-hidden="true"></i> {{$time}}</li>
                        @endif
                    @endforeach
                    @endif
                    @foreach($service->addresses as $address)
                    <li><i class="fa fa-map-marker"
                            aria-hidden="true"></i>{{$address->address}},{{$address->city}},{{$address->state}},{{$address->country}},{{$address->zipcode}}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>