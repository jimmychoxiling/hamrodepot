@extends('Backend.layouts.app', ['title' => __('Voucher')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="{{ route('voucher') }}">Discount Coupons</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Edit Discount Coupons</li>
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
                        <h3 class="mb-0">Edit Discount Coupon</h3>
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

                    <form method="post" action="{{ route('voucher-update',['id' => $voucher->id]) }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
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
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Enter Name" value="{{ old('name', $voucher->name) }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-type">Description</label>
                                        <input type="text" name="type" id="input-type" class="form-control form-control-alternative" placeholder="Enter Description" value="{{ old('type', $voucher->type) }}" required autofocus data-parsley-required-message="Type is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-order_amount">Minumum Order Amount</label>
                                        <input type="number" name="order_amount" id="input-order_amount" class="form-control form-control-alternative" placeholder="order_amount" value="{{ old('order_amount', $voucher->order_amount) }}" required autofocus data-parsley-required-message="order_amount is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-discount_amount">Discount in Percentage</label>
                                        <input type="number" name="discount_amount" id="input-discount_amount" min="1" max="99" class="form-control " placeholder="Enter Discount percentage. %" value="{{ old('discount_amount', $voucher->discount_amount) }}" required autofocus data-parsley-required-message="discount_amount is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-starts_at">Starts At</label>
                                        <input type="date" name="starts_at" id="input-starts_at" class="form-control form-control-alternative" placeholder="starts_at" value="{{ old('starts_at', $voucher->starts_at, date('d-m-Y')) }}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-expires_at">Expires At</label>
                                        <input type="date" name="expires_at" id="input-expires_at" class="form-control form-control-alternative" placeholder="expires_at" value="{{ old('expires_at', $voucher->expires_at, date('d-m-Y'))  }}" >
                                    </div>
                                </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-code">Code</label>
                                        <input type="text" name="code" id="input-code" class="form-control form-control-alternative" placeholder="code" value="{{ old('code', $voucher->code) }}" required autofocus data-parsley-required-message="code is required" readonly>
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
<script type="text/javascript">
    // $("#input-starts_at").prop("min", moment(new Date()).format('YYYY-MM-DD'));
    $("#input-expires_at").prop("min", moment(new Date()).format('YYYY-MM-DD'));
</script>
@endsection
