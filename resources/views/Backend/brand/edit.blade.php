@extends('Backend.layouts.app', ['title' => __('Brand')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('brand') }}">Brand</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Brand</li>
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
                        <h3 class="mb-0">Edit Brand</h3>
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

                    <form method="post" action="{{ route('brand-update',['id' => $brand->id]) }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
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

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Name" value="{{ old('name', $brand->name) }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                                @role('Admin')
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Status</label>
                                        <select name="status" class="form-control form-control-alternative" required data-parsley-required-message="Status is required">
                                            @if($brand->status == 0)
                                            <option value="0" {{(old('status', $brand->status) == '0' ? 'selected':'')}}>Pending
                                            </option>
                                            @endif
                                            <option value="1" {{(old('status', $brand->status) == '1' ? 'selected':'')}}>Active
                                            </option>
                                            @if($brand->status == 1 || $brand->status == 2)
                                            <option value="2" {{(old('status', $brand->status) == '2' ? 'selected':'')}}>In-Active
                                            </option>
                                            @endif
                                            @if($brand->status == 0 || $brand->status == 3)
                                            <option value="3" {{(old('status', $brand->status) == '3' ? 'selected':'')}}>Reject
                                            </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @endrole
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-image">Image</label>
                                        <div class="profile-icon">

                                            @if(!empty($brand->image) && \Illuminate\Support\Facades\Storage::exists($brand->image))
                                            <img class='img-responsive' id="uploadPreview1" src="{{ url('storage') . '/' .  $brand->image}}" style="height: 150px;">
                                            @else
                                            <img class='img-responsive' id="uploadPreview1" src="{{ url('storage/no_image.png')}}" style="height: 150px;">
                                            @endif
                                        </div>
                                        <div class="m-b-10">
                                            <input type="file" accept="image/x-png, image/gif, image/jpeg" id="uploadImage1" class="btn btn-block btn-sm" name="image" onChange="this.parentNode.nextSibling.value = this.value; PreviewImage(1);">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Update</button>
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
