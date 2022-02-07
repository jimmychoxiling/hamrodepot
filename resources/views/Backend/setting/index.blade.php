@extends('Backend.layouts.app', ['title' => __('Setting')])

@section('content')

    <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Setting</li>
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
            <div class="col">
                <div class="card">
                    <!-- Card header -->
                    <div class="card-header border-0">
                        <h3 class="mb-0">Setting</h3>
                    </div>
                    <div class="card-body">
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
                    <!-- Light table -->
                        <div class="table-responsive">
                            <table class="table align-items-center table-flush yajra-datatable"
                                   id="setting-datatable">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Key</th>
                                    <th scope="col">Value</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('Backend.layouts.footers.auth')
    </div>
@endsection

@section('extra-js')
    <script type="text/javascript">

        $('#setting-datatable').DataTable({
            ajax: {
                type: 'POST',
                url: "{{ route('getSetting-datatable')}}"
            },
            processing: true,
            serverSide: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'key', name: 'Key'},
                {data: 'value', name: 'Value'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                }
            ]
        });
    </script>
@endsection
