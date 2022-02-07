@extends('Backend.layouts.app', ['title' => __('Products')])

@section('extra-css')

@endsection
@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    {{-- <h6 class="h2 text-white d-inline-block mb-0">Products</h6>--}}
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Products</li>
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
                    <h3 class="mb-0">Edit Products</h3>
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
                    <form method="post" action="{{ route('products-update',['id' => $products->id]) }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf
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
                            <h1>Basic Detail</h1>
                            <hr />
                            @role('Admin')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-seller">Seller</label>
                                        <select name="seller_id" class="form-control form-control-alternative" required data-parsley-required-message="Seller is required" disabled>
                                            <option value="">Select Seller</option>
                                            @foreach($seller as $seller_val)
                                            <option value="{{$seller_val->id}}" {{(old('seller_id',$products->seller_id) == $seller_val->id ? 'selected':'')}}>{{$seller_val->name}} {{$seller_val->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Status</label>
                                        <select name="status" class="form-control form-control-alternative" required data-parsley-required-message="Status is required">
                                            @if($products->status == 0)
                                            <option value="0" {{(old('status', $products->status) == '0' ? 'selected':'')}}>Pending
                                            </option>
                                            @endif
                                            <option value="1" {{(old('status', $products->status) == '1' ? 'selected':'')}}>Active
                                            </option>
                                            @if($products->status == 1 || $products->status == 2)
                                            <option value="2" {{(old('status', $products->status) == '2' ? 'selected':'')}}>Inactive
                                            </option>
                                            @endif
                                            @if($products->status == 0 || $products->status == 3)
                                            <option value="3" {{(old('status', $products->status) == '3' ? 'selected':'')}}>Reject
                                            </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endrole
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Name" value="{{ old('name', $products->name) }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-sku">SKU</label>
                                        <input type="text" name="sku" id="input-sku" class="form-control form-control-alternative" placeholder="SKU" value="{{ old('sku', $products->sku) }}" required data-parsley-required-message="SKU is required">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Category</label>
                                        <select name="category_id[]" id="category_id" class="form-control form-control-alternative multiselect" required multiple="multiple" data-parsley-required-message="Category is required">
                                            @foreach($category as $category_val)
                                            <option value="{{$category_val->id}}" @if(in_array($category_val->id, $productsCategory)) selected @endif>{{$category_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-subcategory_id">Sub Category</label>
                                        <select name="subcategory_id[]" id="subcategory_id" class="form-control form-control-alternative multiselect" required multiple="multiple" data-parsley-required-message="Sub Category is required">
                                            @foreach($sub_category as $sub_category_val)
                                            <option value="{{$sub_category_val->id}}" @if(in_array($sub_category_val->id, $productsCategory)) selected @endif>{{$sub_category_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="category_types">
                                        <label class="form-control-label" for="input-type_id">Type</label>
                                        <select name="type_id[]" id="type_id" class="form-control form-control-alternative select2" multiple="multiple" @if(count($types)> 0) required data-parsley-required-message="Type is required" @endif>
                                            @foreach($types as $type_val)
                                            <option value="{{$type_val->id}}" @if(in_array($type_val->id, $productsCategory)) selected @endif>{{$type_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Brand</label>
                                        <select name="brands_id" class="form-control form-control-alternative" required data-parsley-required-message="Brand is required">
                                            <option value="">Select Brand</option>
                                            @foreach($brand as $brand_val)
                                            <option value="{{$brand_val->id}}" @if($products->brands_id == $brand_val->id)
                                                selected="selected" @endif>{{$brand_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                    <div class="checkbox_wrapper">
                                        <input type="checkbox" name="show_home_feature" id="input-show-home" class="form-control" {{(old('show_home_feature', $products->show_home_feature) == '1' ? 'checked': '' )}}>
                                        <label class="form-control-label" for="input-show-home">Show Product On Home Page Featured List</label>
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-description">Description</label>
                                        <textarea class="form-control form-control-alternative" rows="5" placeholder="Description" name="description" required data-parsley-required-message="Description is required">{{ old('description', $products->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h1>Product Price Detail</h1>
                            <hr />
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-product-plan">Sell Type</label>
                                        <select name="sell_type" class="form-control form-control-alternative" required data-parsley-required-message="Sell Type is required">
                                            <option value="" selected disabled>Select Sell Type</option>
                                            <option value="Sell" {{(old('sell_type', $products->sell_type) == 'Sell' ? 'selected':'')}}>Sell</option>
                                            <option value="Rent" {{(old('sell_type', $products->sell_type) == 'Rent' ? 'selected':'')}}>Rent</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-price">Price</label>
                                        <input type="text" name="price" id="input-price" class="form-control form-control-alternative" placeholder="Price" value="{{ old('price', $products->price) }}" required data-parsley-required-message="Price is required" data-parsley-trigger="keyup" data-parsley-type="number">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-control-label" for="input-stock">Stock </label>
                                    <input type="text" name="stock" id="input-stock" class="form-control form-control-alternative" placeholder="Stock" value="{{ old('stock', $products->stock) }}" required data-parsley-required-message="Stock is required" data-parsley-trigger="keyup" data-parsley-type="number">
                                </div>
                            </div>
                            <hr />
                            <h1>Other Details</h1>
                            <hr />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-product_overview">Product Overview</label>
                                        <textarea class="form-control form-control-alternative" rows="3" placeholder="Product Overview" name="product_overview" required data-parsley-required-message="Product Overview is required">{{ old('product_overview', $products->product_overview) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-specifications">Specifications</label>
                                        <textarea class="form-control form-control-alternative" rows="3" placeholder="Specifications" name="specifications" required data-parsley-required-message="Specifications is required">{{ old('specifications', $products->specifications) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-easy_returns">Easy Returns</label>
                                        <textarea class="form-control form-control-alternative" rows="3" placeholder="Easy Returns" name="easy_returns" required data-parsley-required-message="Easy Returns is required">{{ old('easy_returns', $products->easy_returns) }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h1>Images</h1>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-images">Images</label>
                                    <div class="input-group control-group increment">
                                        <input type="file" name="filename[]" class="form-control" multiple="true">
                                        <div class="input-group-btn">
                                            <button class="btn btn-success btn-add" type="button">+
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="clone" style="display: none">
                                        <div class="control-group input-group" style="margin-top:10px">
                                            <input type="file" name="filename[]" class="form-control" multiple="true">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button">-
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                @foreach($products->productsImages as $productsImages)
                                <div class="col-md-3 proImg_{{$productsImages->id}}">
                                    <div class="product_upload_img">
                                        @if(!empty($productsImages->filename) && \Illuminate\Support\Facades\Storage::exists($productsImages->filename))
                                        <img src="{{ url('storage') . '/' . $productsImages->filename}}">
                                        @else
                                        <img src="{{ url('storage/no_image.png')}}">
                                        @endif
                                        <a href="javascript:void(0);" data-id="{{$productsImages->id}}" class="removeImage" style="margin-left: -17px;vertical-align: top;color: red;"><i class="fas fa-times-circle"></i></a>
                                    </div>
                                </div>
                                @endforeach
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
<script type="text/javascript">
    $(document).ready(function() {
        $(".btn-add").click(function() {
            var html = $(".clone").html();
            $(".increment").after(html);
        });
        $("body").on("click", ".btn-danger", function() {
            $(this).parents(".control-group").remove();
        });
    });

    CKEDITOR.replace('product_overview');
    CKEDITOR.replace('specifications');
    CKEDITOR.replace('easy_returns');

    $(document).ready(function() {
        $("#category_id").select2({
            placeholder: "Select Category",
            allowClear: true
        });
        $("#subcategory_id").select2({
            placeholder: "Select Sub Category",
            allowClear: true
        });
        $("#type_id").select2({
            placeholder: "Select Types",
            allowClear: true
        });
    });

    $('body').on('click', '.removeImage', function(event) {
        var result = confirm("Are You sure you want to delete?");
        if (result) {
            if ($(this).attr('data-id')) {
                var images_id = $(this).attr('data-id');
                $.ajax({
                    type: "GET",
                    url: "{{ route('remove-products-images')}}",
                    data: {
                        id: images_id
                    },
                    success: function(data) {
                        if (data.status == true) {
                            $('.proImg_' + images_id).remove();
                            // location.reload();
                        }
                    },
                    error: function(jqXhr) {
                        if (jqXhr.status === 422) {

                        }
                    }
                });
            } else {
                $(this).parent().parent().remove();
            }
            event.preventDefault();
        }
    });
    $(document).ready(function() {
        $('#category_id').on('change', function() {

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "post",
                url: "{{ route('getSubCategory')}}",
                data: {
                    _token: CSRF_TOKEN,
                    category_id: $(this).val()
                },
                success: function(data) {
                    // $("#subcategory_id").val([]);
                    $('#subcategory_id').html(data.html);

                }
            });
        });
        $('#subcategory_id').on('change', function() {

            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: "post",
                url: "{{ route('getTypes')}}",
                data: {
                    _token: CSRF_TOKEN,
                    sub_category_id: $(this).val()
                },
                success: function(data) {
                    // $("#subcategory_id").val([]);
                    $('#category_types').html(data.html);

                    $("#type_id").select2({
                        placeholder: "Select Types",
                        allowClear: true
                    });

                }
            });
        });
    });
</script>

@endsection