@extends('Backend.layouts.app', ['title' => __('Products')])

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
                            <li class="breadcrumb-item active" aria-current="page">Show</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('products-create') }}" class="btn btn-sm btn-neutral">Add New Products</a>
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
                    <h3 class="mb-0">Products</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col col-md-12">
                            <table class="table table-bordered c_product_table">
                                <tbody>
                                    <tr>
                                        <th><b>Name</b></th>
                                        <td>{{$products->name}}</td>
                                    </tr>
                                    <tr>
                                        <th><b>SKU</b></th>
                                        <td>{{$products->sku}}</td>
                                    </tr>

                                    <tr>
                                        <th><b>Status</b></th>
                                        <td>
                                            @if($products->status == '1')
                                            Active
                                            @elseif($products->status == '0')
                                            Inactive
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>Description</b></th>
                                        <td style="white-space: normal;">{!! $products->description !!}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Category</b></th>
                                        <td>
                                            @foreach($products->categories as $category)
                                            @if($category->parent_id == null)
                                            {{ $category->name }}@if(!$loop->last),@endif
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>Sub Category</b></th>
                                        <td>
                                            @foreach($products->categories as $category)
                                            @if($category->parent_id != null && $category->level == 2)
                                            {{ $category->name }}@if(!$loop->last),@endif
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>Type</b></th>
                                        <td>
                                            @foreach($products->categories as $category)
                                            @if($category->parent_id != null && $category->level == 3)
                                            {{ $category->name }}@if(!$loop->last),@endif
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><b>Brand</b></th>
                                        <td>{{ $products->brand->name }}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Sell Type</b></th>
                                        <td>{{ $products->sell_type }}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Price</b></th>
                                        <td>{{ config('constant.CURRENCY_SIGN') }}{{ $products->price }}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Stock</b></th>
                                        <td>{{ $products->stock }}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Product Overview</b></th>
                                        <td>{!! $products->product_overview !!}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Specifications</b></th>
                                        <td>{!! $products->specifications !!}</td>
                                    </tr>
                                    <tr>
                                        <th><b>Easy Returns</b></th>
                                        <td>{!! $products->easy_returns !!}</td>
                                    </tr>

                                    <tr>
                                        <th><b>Image</b></th>
                                        <td>
                                            @foreach($products->productsImages as $productsImages)
                                            @if(!empty($productsImages->filename) && \Illuminate\Support\Facades\Storage::exists($productsImages->filename))
                                            <img src="{{ url('storage') . '/' . $productsImages->filename}}" style="height: 150px;">
                                            @else
                                            <img src="{{ url('storage/no_image.png')}}" style="height: 150px;">
                                            @endif
                                            @endforeach
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('Backend.layouts.footers.auth')
</div>
@endsection

@section('extra-js')

@endsection