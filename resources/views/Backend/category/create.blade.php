@extends('Backend.layouts.app', ['title' => __('Category')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('category') }}">Category</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Category</li>
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
                        <h3 class="mb-0">Add Category</h3>
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
                    <form method="post" action="{{ route('category-store') }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Name" value="{{ old('name') }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="checkbox_wrapper">
                                            <input type="checkbox" name="show_home_page" id="input-show-home" class="form-control">
                                            <label class="form-control-label" for="input-show-home">Show Home Page Category</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="checkbox_wrapper">
                                            <input type="checkbox" name="show_home_top_category" id="input-show-home-top" class="form-control">
                                            <label class="form-control-label" for="input-show-home-top">Show Home Page Top Category</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Description</label>
                                        <textarea class="form-control form-control-alternative" rows="5" name="description" value="{{ old('description') }}" require data-parsley-required-message="Description is required"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-image">Image</label>
                                        <div class="profile-icon">
                                            <img class='img-responsive' id="uploadPreview1" src="" style="height: 150px;">
                                        </div>
                                        <div class="m-b-10">
                                            <input type="file" accept="image/x-png, image/gif, image/jpeg" id="uploadImage1" class="btn btn-block btn-sm" name="image" onChange="this.parentNode.nextSibling.value = this.value; PreviewImage(1);">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="text-center">
                                <button type="submit" class="btn btn-success mt-4">Add</button>
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