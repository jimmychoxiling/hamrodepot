<div id="services-addresses">
    @if($is_edit && $service->addresses->count() > 0)
        @foreach ($service->addresses as $key => $address)
        <div class="single-address-row">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-control-label">Address</label>
                        <input type="text" name="address[{{ $key+1 }}]" class="form-control form-control-alternative auto-complete-address" placeholder="Address" value="{{ $address->address }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-control-label">Country</label>
                        <input type="text" name="country[{{ $key+1 }}]" class="form-control form-control-alternative country" placeholder="Country" value="{{ $address->country }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-1 more-address-btn d-flex justify-content-end">
                    @if($key == 0)
                        <a href="javascript:void(0);" class="addMoreAddress"><i class="fas fa-plus btn btn-success"></i></a>
                    @else
                        <a href="javascript:void(0);" class="removeAddress"><i class="fas fa-minus btn btn-danger"></i></a>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">State</label>
                        <input type="text" name="state[{{ $key+1 }}]" class="form-control form-control-alternative state" placeholder="State" value="{{ $address->state }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">City</label>
                        <input type="text" name="city[{{ $key+1 }}]" class="form-control form-control-alternative city" placeholder="City" value="{{ $address->city }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Zipcode</label>
                        <input type="number" name="zipcode[{{ $key+1 }}]" class="form-control form-control-alternative zipcode" placeholder="Zip Code" value="{{ $address->zipcode }}" autocomplete="off">
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Latitude</label>
                        <input type="text" name="lat[{{ $key+1 }}]" class="form-control form-control-alternative lat" placeholder="Latitude" value="{{ $address->lat }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Longitude</label>
                        <input type="text" name="lng[{{ $key+1 }}]" class="form-control form-control-alternative lng" placeholder="Longitude" value="{{ $address->lng }}" autocomplete="off">
                    </div>
                </div> -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Price</label>
                        <input type="text" name="price[{{ $key+1 }}]" class="form-control form-control-alternative" placeholder="Price" value="{{ $address->price }}">
                    </div>
                </div> -->
            </div>
        </div>
        @endforeach
    @else
        <div class="single-address-row">
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="form-control-label">Address</label>
                        <input type="text" name="address[1]" class="form-control form-control-alternative auto-complete-address" placeholder="Address" value="" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-control-label">Country</label>
                        <input type="text" name="country[1]" class="form-control form-control-alternative country" placeholder="Country" value="" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-1 more-address-btn d-flex justify-content-end">
                    <a href="javascript:void(0);" class="addMoreAddress"><i class="fas fa-plus btn btn-success"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">State</label>
                        <input type="text" name="state[1]" class="form-control form-control-alternative state" placeholder="State" value="" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">City</label>
                        <input type="text" name="city[1]" class="form-control form-control-alternative city" placeholder="City" value="" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Zipcode</label>
                        <input type="number" name="zipcode[1]" class="form-control form-control-alternative zipcode" placeholder="Zip Code" value="" autocomplete="off">
                    </div>
                </div>
            </div>
            <!-- <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Latitude</label>
                        <input type="text" name="lat[1]" class="form-control form-control-alternative lat" placeholder="Latitude" value="" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Longitude</label>
                        <input type="text" name="lng[1]" class="form-control form-control-alternative lng" placeholder="Longitude" value="" autocomplete="off">
                    </div>
                </div> -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-control-label">Price</label>
                        <input type="text" name="price[1]" class="form-control form-control-alternative" placeholder="Price" value="">
                    </div>
                </div> -->
            </div>
        </div>
    @endif
</div>
<hr/>