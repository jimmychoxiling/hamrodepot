@extends('Backend.layouts.app', ['title' => __('DIY & Articles')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('blog') }}">DIY & Articles</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit DIY & Articles</li>
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
                        <h3 class="mb-0">Edit DIY & Articles</h3>
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

                    <form method="post" action="{{ route('blog-update',['id' => $blog->id]) }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
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
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Name" value="{{ old('name', $blog->name) }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-category">Category</label>
                                        <select name="blog_category_id" id="blog_category_id" class="form-control form-control-alternative" required data-parsley-required-message="Category is required">
                                            <option value="" selected disabled>Select Category</option>
                                            @foreach($blog_category as $blog_category_val)
                                                <option value="{{ $blog_category_val->id }}" {{(old('blog_category_id',$blog->blog_category_id) == $blog_category_val->id ? 'selected':'')}}>{{$blog_category_val->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-author">Author</label>
                                        <input type="text" name="author" id="input-author" class="form-control form-control-alternative" placeholder="Author" value="{{ old('author', $blog->author) }}" required  data-parsley-required-message="Author is required">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-description">Description</label>
                                        <textarea class="form-control form-control-alternative" rows="5" name="description"require data-parsley-required-message="Description is required">{{ old('description', $blog->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-image">Image</label>
                                        <div class="profile-icon">

                                            @if(!empty($blog->image) && \Illuminate\Support\Facades\Storage::exists($blog->image))
                                                <img class='img-responsive' id="uploadPreview1" src="{{ url('storage') . '/' .  $blog->image}}" style="height: 150px;">
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
        CKEDITOR.replace('description');

        function PreviewImage(no) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("uploadImage" + no).files[0]);
            oFReader.onload = function(oFREvent) {
                document.getElementById("uploadPreview" + no).src = oFREvent.target.result;
            };
        }
    </script>
@endsection
