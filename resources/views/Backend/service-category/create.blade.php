@extends('Backend.layouts.app', ['title' => __('Service-Category')])
@section('content')
@php 
    $title = "Category"; 
    $is_edit = 0; 
    if(!is_null($category)){ 
    $is_edit = 1; 
    }
@endphp
<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('service.category') }}">Service {{ $title }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $is_edit ? 'Edit' : 'Add' }} Service {{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                @role('seller')
                @if($is_edit)
                <div class="col-md-6 d-flex align-items-center justify-content-end">
                    @php
                            $statusArr = array_flip(config('constant.STATUS'));
                            $status = $statusArr[$category->status];
                            $class = 'info';
                            if($category->status == 1){
                            $class = 'success';
                            } elseif($category->status == 2 || $category->status == 3){
                            $class = 'danger';
                            }
                    @endphp
                    <span class="status badge badge-pill badge-{{$class}}">{{ $status }}</span>
                </div>
                @endif
                @endrole
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
                    <form method="post" action="{{ route('service.category.store') }}" autocomplete="off" enctype="multipart/form-data" class="category-form">
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
                                        <label class="form-control-label"
                                            for="input-name">Name</label>
                                        <input type="text" name="name" id="input-name"
                                            class="form-control form-control-alternative"
                                            placeholder="Name" value="{{ $is_edit && isset($category->name) ? $category->name : old('name') }}" required
                                            autofocus>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-image">Image</label>
                                        <div class="profile-icon">
                                            @if($is_edit)
                                            @if(!empty($category->image) && \Illuminate\Support\Facades\Storage::exists($category->image))
                                            <img class='img-responsive' id="uploadPreview1" src="{{ asset('storage') . '/' .  $category->image}}" style="height: 150px;">
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
                            <input type="hidden" name="id" value="{{ $category ? $category->id : '' }}" class="category-id">
                            <div class="text-center">
                                <a href="{{ route('service.category') }}" class="btn btn-primary mt-4">Cancel</a>
                                <button type="submit" class="btn btn-success mt-4">{{ $category ? 'Update' : 'Add' }}</button>
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection