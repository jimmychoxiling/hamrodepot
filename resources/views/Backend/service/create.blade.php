@extends('Backend.layouts.app', ['title' => __('Service')])
@section('extra-css')
<link href="{{ asset('assets/vendor/select2/dist/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('content')
@php $is_edit = 0; if(!is_null($service)){ $is_edit = 1; }  @endphp
    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('services') }}">Service</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $is_edit ? 'Edit' : 'Add' }} Service</li>
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
                            <h3 class="mb-0">{{ $is_edit ? 'Edit' : 'Add' }} Service</h3>
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
                        <form method="post" action="{{ route('service.store') }}" autocomplete="off" enctype="multipart/form-data" class="service-form">
                            @csrf

                            @if ($message = Session::get('success'))
                                <div class="alert alert-success alert-dismissible fade show"
                                     role="alert">
                                    {{ $message }}
                                    <button type="button" class="close" data-dismiss="alert"
                                            aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-status">Category</label>
                                            <select name="service_category_id" id="service_category_id" class="form-control form-control-alternative form-control-select2 select2">
                                                <option value="">Select Service Category</option>
                                                @foreach ($serviceCategories as $ct)
                                                    <option value="{{ $ct->id }}" {{ $is_edit ? ($ct->id == $service->service_category_id ? 'selected' : '') : (old('service_category_id') == $ct->id ? 'selected':'') }}>{{ $ct->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="input-name">Name</label>
                                            <input type="text" name="name" id="input-name"
                                                   class="form-control form-control-alternative"
                                                   placeholder="Name" value="{{ $is_edit && isset($service->name) ? $service->name : old('name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                    <div class="form-group">
                                            <label class="form-control-label">Price</label>
                                            <input type="text" name="price" class="form-control form-control-alternative" placeholder="Price" value="{{ $is_edit ? $service->price : old('price')}}">
                                        </div>

                                        <!-- <div class="form-group">
                                            <label class="form-control-label" for="input-status">Tag</label>
                                            <select name="tag" id="tag" class="form-control form-control-alternative">
                                                <option value="">Select Tag</option>
                                                <option value="featured" {{ $is_edit ? ($service->tag == 'featured' ? 'selected' : '') : (old('tag') == 'featured' ? 'selected' : '') }}>Featured</option>
                                                <option value="top" {{ $is_edit ? ($service->tag == 'top' ? 'selected' : '') : (old('tag') == 'top' ? 'selected' : '') }}>Top</option>
                                                <option value="new" {{ $is_edit ? ($service->tag == 'new' ? 'selected' : '') : (old('tag') == 'new' ? 'selected' : '') }}>New</option>
                                            </select>
                                        </div> -->
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group time-check">
                                            <label class="form-control-label" for="input-status">Timing</label>
                                            <div class="service-timings d-flex">
                                                @foreach (config('constant.SERVICE_TIMING') as $tk => $time)
                                                    <div class="custom-control custom-control-alternative custom-checkbox mb-3 mr-3">
                                                        <input class="custom-control-input" id="time{{ $tk }}" type="checkbox" name="time[]" value='{{ $tk }}' >
                                                        <label class="custom-control-label" for="time{{ $tk }}">{{ $time }}</label>
                                                    </div>  
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-description">Description</label>
                                            <textarea class="form-control form-control-alternative" rows="5" placeholder="Description" name="description">{{ $is_edit ? $service->description : old('description')}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @include('Backend.service.address')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label" for="input-image">Image</label>
                                            <div class="profile-icon">
                                                @if($is_edit)
                                                    @if(!empty($service->image) && \Illuminate\Support\Facades\Storage::exists($service->image))
                                                        <img class='img-responsive' id="uploadPreview1" src="{{ asset('storage') . '/' .  $service->image}}" style="height: 150px;">
                                                    @else
                                                        <img class='img-responsive' id="uploadPreview1" src="{{asset('image/no_image.png')}}" style="height: 150px;">
                                                    @endif
                                                @else 
                                                    <img class='img-responsive' id="uploadPreview1" src="" style="height: 150px;">
                                                @endif
                                            </div>
                                            <div class="m-b-10">
                                                <input type="file" accept="image/png, image/gif, image/jpeg" id="uploadImage1" class="btn btn-block btn-sm" name="image" onChange="this.parentNode.nextSibling.value = this.value; PreviewImage(1);">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="{{ $is_edit ? $service->id : '' }}" class="service-id">
                                <div class="text-center">
                                    <a href="{{ route('services') }}" class="btn btn-primary mt-4">Cancel</a>
                                    <button type="submit" class="btn btn-success mt-4">{{ $is_edit ? 'Update' : 'Add' }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extra-js')
<script src="{{asset('js/validate.min.js')}}"></script>
<script src="{{asset('js/additional_methods.min.js')}}"></script>
<script src="{{ asset('assets/vendor/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?key={{ env('PLACE_API_KEY') }}&sensor=false&libraries=places"></script>
<script>
    var base_url = "{{ url('/') }}/";
</script>
<script src="{{ asset('js/pages/admin/service.js') }}"></script>
@endsection