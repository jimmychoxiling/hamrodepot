@extends('Backend.layouts.app', ['title' => __('Users')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item"><a href="{{ route('user') }}">Users</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Add Users</li>
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
                            <h3 class="mb-0">Add Users</h3>
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
                        <form method="post" action="{{ route('user-store') }}" autocomplete="off"
                              data-parsley-validate="" enctype="multipart/form-data">
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
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="input-name">Name</label>
                                            <input type="text" name="name" id="input-name"
                                                   class="form-control form-control-alternative"
                                                   placeholder="Name" value="{{ old('name') }}" required
                                                   autofocus
                                                   data-parsley-required-message="Name is required">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="input-last_name">Last Name</label>
                                            <input type="text" name="last_name" id="input-last_name"
                                                   class="form-control form-control-alternative"
                                                   placeholder="Last Name" value="{{ old('last_name') }}" required
                                                   autofocus
                                                   data-parsley-required-message="Last Name is required">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="input-email">Email</label>
                                            <input type="email" name="email" id="input-name"
                                                   class="form-control form-control-alternative"
                                                   placeholder="Email" value="{{ old('email') }}" required
                                                   autofocus
                                                   data-parsley-required-message="Email is required">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                   for="input-name">Password</label>
                                            <input type="password" name="password" id="input-password"
                                                   class="form-control form-control-alternative"
                                                   placeholder="Password" value="{{ old('password') }}" required
                                                   autofocus
                                                   data-parsley-required-message="Password is required">
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

@endsection

