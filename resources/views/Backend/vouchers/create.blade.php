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
                            <li class="breadcrumb-item"><a href="{{ route('voucher') }}">Voucher</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Voucher</li>
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
                        <h3 class="mb-0">Add Voucher</h3>
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
                    <form method="post" action="{{ route('voucher-store') }}" autocomplete="off" data-parsley-validate="" enctype="multipart/form-data">
                        @csrf

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
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
                                        <input type="text" name="name" id="input-name" class="form-control form-control-alternative" placeholder="Enter Name" value="{{ old('name') }}" required autofocus data-parsley-required-message="Name is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-type">Description</label>
                                        <input type="text" name="type" id="input-type" class="form-control form-control-alternative" placeholder="Enter Description" value="{{ old('type') }}" required autofocus data-parsley-required-message="Type is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-order_amount">Minumum Order Amount</label>
                                        <input type="number" name="order_amount" id="input-order_amount" class="form-control form-control-alternative"  placeholder="Enter Minumum Order Amount" value="{{ old('order_amount') }}" required autofocus data-parsley-required-message="order Amount is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-discount_amount">Discount in Percentage</label>
                                        <input type="number" name="discount_amount" id="input-discount_amount" class="form-control " min="1" max="99" placeholder="Enter Discount percentage. %" value="{{ old('discount_amount') }}" required autofocus data-parsley-required-message="Discount Amount is required">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="starts_at">Starts At</label>
                                        <input type="date" name="starts_at" id="starts_at" class="form-control" value="{{ old('starts_at', date('d-m-Y')) }}"  placeholder="from">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="expires_at">Expires At</label>
                                        <input type="date" name="expires_at" id="expires_at" class="form-control"  placeholder="from" value="{{ old('expires_at', date('d-m-Y')) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-code">Code</label>
                                        <input type="text" name="code"  minlength="5" maxlength="10" id="input-code" class="form-control form-control-alternative" placeholder="code" value="{{ old('code') }}" required autofocus data-parsley-required-message="Code is required! ">
                                    </div></div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-code"> &nbsp;  &nbsp; </label>
                                        <input type="button"  class="form-control form-control-alternative  btn-primary code-generate" value="Generate a code " >

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

$(document).on('click', '.code-generate', function (e) {
    var text = "";
  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

  for (var i = 0; i < 10; i++)
    text += possible.charAt(Math.floor(Math.random() * possible.length));
    $('#input-code').val(text);
});
    $("#starts_at").prop("min", moment(new Date()).format('YYYY-MM-DD'));
    $("#expires_at").prop("min", moment(new Date()).format('YYYY-MM-DD'));
</script>
@endsection
