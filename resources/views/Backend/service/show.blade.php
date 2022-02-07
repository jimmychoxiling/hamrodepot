@extends('Backend.layouts.app', ['title' => __('Service')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('services') }}">Services</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Show</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-lg-6 col-5 text-right">
                        @if(Auth::user()->hasRole('Seller'))
                            <a href="{{ route('service.create') }}" class="btn btn-sm btn-neutral">Add New Service</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container-fluid mt--6">
        <div class="row">
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Service</h3>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <th><b>Name</b></th>
                                    <td>{{ $service->name }}</td>
                                </tr>
                                <tr>
                                    <th><b>Status</b></th>
                                    <td>
                                        @php
                                            $statusArr = array_flip(config('constant.STATUS'));
                                            $status = $statusArr[$service->status];
                                            $class = 'info';
                                            if($service->status == 1){
                                                $class = 'success';
                                            } elseif($service->status == 2 || $service->status == 3){
                                                $class = 'danger';
                                            }

                                            echo '<span class="status badge badge-pill badge-'.$class.'">'.$status.'</span>';
                                        @endphp  
                                    </td>
                                </tr>
                                <tr>
                                    <th><b>Seller</b></th>
                                    <td>{{ $service->seller->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th><b>Category</b></th>
                                    <td>{{ $service->category->name ?? '-' }}</td>
                                </tr>
                                <!-- <tr>
                                    <th><b>Tag</b></th>
                                    <td>{{ $service->tag ? ucFirst($service->tag) : '-' }}</td>
                                </tr> -->
                                <tr>
                                    <th><b>Time</b></th>
                                    <td>
                                    @php  $str_time  = json_decode($service->time,true); @endphp
                                        @foreach (config('constant.SERVICE_TIMING') as $tk => $time)
                                            @if(in_array($tk,$str_time))
                                             {{ $time}} ,
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th><b>Description</b></th>
                                    <td style="white-space: normal;">{!! $service->description !!}</td>
                                </tr>
                                <tr>
                                    <th><b>Price</b></th>
                                    <td style="white-space: normal;">{!! $service->price !!}</td>
                                </tr>
                                <tr>
                                    <th><b>Image</b></th>
                                    <td>
                                        @if(!empty($service->image) && \Illuminate\Support\Facades\Storage::exists($service->image))
                                        <a href="{{ url('storage') . '/' . $service->image}}" data-fancybox="gallery">
                                            <img src="{{ url('storage') . '/' . $service->image}}" style="height: 150px;">
                                        </a>
                                        @else
                                            <img src="{{ url('storage/no_image.png')}}" style="height: 150px;">
                                        @endif
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                        @if(!empty($service->addresses) && $service->addresses->count())
                                <h2 style="margin-top: 15px;">Addresses</h2>
                                <hr/>
                                @foreach ($service->addresses as $key => $address)
                                    <div class="single-address-row">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label class="form-control-label">Address</label>
                                                    <input type="text" name="address[{{ $key+1 }}]" class="form-control form-control-alternative" value="{{ $address->address }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="form-control-label">Country</label>
                                                    <input type="text" name="country[{{ $key+1 }}]" class="form-control form-control-alternative country" value="{{ $address->country }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">State</label>
                                                    <input type="text" name="state[{{ $key+1 }}]" class="form-control form-control-alternative state" value="{{ $address->state }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">City</label>
                                                    <input type="text" name="city[{{ $key+1 }}]" class="form-control form-control-alternative city" value="{{ $address->city }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Zipcode</label>
                                                    <input type="number" name="zipcode[{{ $key+1 }}]" class="form-control form-control-alternative zipcode" value="{{ $address->zipcode }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Latitude</label>
                                                    <input type="text" name="lat[{{ $key+1 }}]" class="form-control form-control-alternative lat" value="{{ $address->lat }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Longitude</label>
                                                    <input type="text" name="lng[{{ $key+1 }}]" class="form-control form-control-alternative lng" value="{{ $address->lng }}" readonly>
                                                </div>
                                            </div> -->
                                            <!-- <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="form-control-label">Price</label>
                                                    <input type="text" name="price[{{ $key+1 }}]" class="form-control form-control-alternative" value="{{ $address->price }}" readonly>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                            @endif
                    </div>

                </div>
            </div>
        </div>

        @include('Backend.layouts.footers.auth')
    </div>
@endsection

@section('extra-js')

@endsection
