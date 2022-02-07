@extends('Backend.layouts.app', ['title' => __('Contact')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact-Us</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
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
                    <h3 class="mb-0">Contact Us</h3>
                </div>
                <div class="card-body">
                    <!-- Light table -->
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush yajra-datatable" id="contact-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Message</th>
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
    $('#contact-datatable').DataTable({
        ajax: {
            type: 'POST',
            url: "{{ route('getContact-datatable')}}"
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'full_name',
                name: 'Name'
            },
            {
                data: 'email',
                name: 'Email'
            },
            {
                data: 'phone',
                name: 'Phone'
            },
            {
                data: 'subject',
                name: 'Subject'
            },
            {
                data: 'message',
                name: 'Message'
            },
             
        ]
    });


</script>
@endsection
