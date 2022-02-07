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
                            <li class="breadcrumb-item active" aria-current="page">Add Products</li>
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
                        <h3 class="mb-0">Add Products</h3>
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
                    <form method="post" action="{{ route('products-store') }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
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
                                        <select name="seller_id" class="form-control form-control-alternative" required data-parsley-required-message="Seller is required">
                                            <option value="">Select Seller</option>
                                            @foreach($seller as $seller_val)
                                            <option value="{{$seller_val->id}}" {{(old('seller_id') == $seller_val->id ? 'selected':'')}}>{{$seller_val->name}} {{$seller_val->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Status</label>
                                        <select name="status" class="form-control form-control-alternative" required data-parsley-required-message="Status is required">
                                            <option value="0" {{(old('status') == '0' ? 'selected':'')}}>Pending
                                            </option>
                                            <option value="1" {{(old('status') == '1' ? 'selected':'')}}>Active
                                            </option>
                                            <option value="2" {{(old('status') == '2' ? 'selected':'')}}>Inactive
                                            </option>
                                            <option value="3" {{(old('status') == '3' ? 'selected':'')}}>Reject
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            @endrole
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-name">Name</label>
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Name" value="{{ old('name') }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-sku">SKU</label>
                                        <input type="text" name="sku" id="input-sku" class="form-control form-control-alternative" placeholder="SKU" value="{{ old('sku') }}" required data-parsley-required-message="SKU is required">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Category</label>
                                        <select name="category_id[]" id="category_id" class="form-control form-control-alternative select2" required multiple="multiple" data-parsley-required-message="Category is required">
                                            @foreach($category as $category_val)
                                            <option value="{{$category_val->id}}" {{(old('category_id') == $category_val->id ? 'selected':'')}}>{{$category_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-subcategory_id">Sub
                                            Category</label>
                                        <select name="subcategory_id[]" id="subcategory_id" class="form-control form-control-alternative select2" required multiple="multiple" data-parsley-required-message="Sub Category is required">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group" id="category_types">
                                        <label class="form-control-label" for="input-type_id">Type</label>
                                        <select name="type_id[]" id="type_id" class="form-control form-control-alternative select2" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-status">Brand</label>
                                        <select name="brands_id" class="form-control form-control-alternative" required data-parsley-required-message="Brand is required">
                                            <option value="">Select Brand</option>
                                            @foreach($brand as $brand_val)
                                            <option value="{{$brand_val->id}}" {{(old('brands_id') == $brand_val->id ? 'selected':'')}}>{{$brand_val->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="checkbox_wrapper">
                                            <input type="checkbox" name="show_home_feature" id="input-show-home-feature" class="form-control">
                                            <label class="form-control-label" for="input-show-home-feature">Show Product On Home Page Featured List</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-description">Description</label>
                                        <textarea class="form-control form-control-alternative" rows="5" placeholder="Description" name="description" required data-parsley-required-message="Description is required">{{ old('description')}}</textarea>
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
                                            <option value="Sell" {{(old('sell_type') == 'Sell' ? 'selected':'')}}>
                                                Sell
                                            </option>
                                            <option value="Rent" {{(old('sell_type') == 'Rent' ? 'selected':'')}}>
                                                Rent
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-price">Price</label>
                                        <input type="text" name="price" id="input-price" class="form-control form-control-alternative" placeholder="Price" value="{{ old('price') }}" required data-parsley-required-message="Price is required" data-parsley-trigger="keyup" data-parsley-type="number">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-control-label" for="input-stock">Stock </label>
                                    <input type="text" name="stock" id="input-stock" class="form-control form-control-alternative" placeholder="Stock" value="{{ old('stock') }}" required data-parsley-required-message="Stock is required" data-parsley-trigger="keyup" data-parsley-type="number">
                                </div>
                            </div>

                            <hr />
                            <h1>Other Details</h1>
                            <hr />

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-product_overview">Product
                                            Overview</label>
                                        <textarea class="form-control form-control-alternative" rows="3" placeholder="Product Overview" name="product_overview" required data-parsley-required-message="Product Overview is required">{{ old('product_overview')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-specifications">Specifications</label>
                                        <textarea class="form-control form-control-alternative" rows="3" placeholder="Specifications" name="specifications" required data-parsley-required-message="Specifications is required">{{ old('specifications')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-easy_returns">Easy
                                            Returns</label>
                                        <textarea class="form-control form-control-alternative" rows="3" placeholder="Easy Returns" name="easy_returns" required data-parsley-required-message="Easy Returns is required">{{ old('easy_returns')}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <hr />
                            <h1>Images</h1>
                            <hr />
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-control-label" for="input-images">Images</label>
                                    <div class="input-group control-group">
                                        <input type="file" name="filename[]" class="form-control">
                                        <div class="input-group-btn">
                                            <button class="btn btn-success btn-add" type="button">+
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="clone" style="display: none">
                                        <div class="control-group input-group increment" style="margin-top:10px">
                                            <input type="file" name="filename[]" class="form-control">
                                            <div class="input-group-btn">
                                                <button class="btn btn-danger" type="button">-
                                                </button>
                                            </div>
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
