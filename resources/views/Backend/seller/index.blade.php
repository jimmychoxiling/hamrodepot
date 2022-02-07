@extends('Backend.layouts.app', ['title' => __('Seller')])

@section('content')

<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Seller</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('seller-create') }}" class="btn btn-sm btn-neutral">Add Seller</a>
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
                    <h3 class="mb-0">Seller</h3>
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
                        <table class="table align-items-center table-flush yajra-datatable" id="seller-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Business Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">commision</th>
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
    $('#seller-datatable').DataTable({
        ajax: {
            type: 'POST',
            url: "{{ route('getSeller-datatable')}}"
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'business_name',
                name: 'business name'
            },
            {
                data: 'email',
                name: 'email'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'commision',
                name: 'commision',
                orderable: true,
                searchable: true
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },

        ]
    });


    $(document).on('click', '.delete', function() {
        var href = $(this).data('href');
        swal({
                title: "",
                text: "Are you sure? Delete this Seller!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: true
            },
            function() {
                location.href = href;
            });
    });

    $(document).on('click', '.statusUpdateSeller', function() {
        var _this = $(this);
        let status = $(this).data('status');
        const id = $(this).data('id');
        let isFor = "";
        if (_this.hasClass('approve-status') || (_this.hasClass('active-inactive') && _this.is(":checked"))) {
            status = 1;
            isFor = 'Active';
        } else {
            status = 2;
            isFor = 'Inactive';
        }
        swal({
                title: "",
                text: "Are you sure? " + isFor + " this Seller!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, " + isFor + " it!",
                closeOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "post",
                        url: "{{route('seller-status-update')}}",
                        data: {
                            id: id,
                            status: status,
                        },
                        success: function(data) {
                            if (data.success) {
                                if (data.status == 1) {
                                    $(_this).parents('tr').find('.active-inactive').prop('checked', true);
                                    $(_this).parents('tr').find('.seller-badge').removeClass('badge-danger').addClass('badge-success');
                                    $(_this).parents('tr').find('.seller-badge').text('Active');
                                } else {
                                    $(_this).parents('tr').find('.active-inactive').prop('checked', false);
                                    $(_this).parents('tr').find('.seller-badge').removeClass('badge-success').addClass('badge-danger');
                                    $(_this).parents('tr').find('.seller-badge').text('In-Active');
                                }
                            }
                        }
                    });
                } else {
                    if (_this.hasClass('active-inactive') && _this.is(":checked")) {
                        $(_this).parents('tr').find('.active-inactive').prop('checked', false);
                    } else {
                        $(_this).parents('tr').find('.active-inactive').prop('checked', true);
                    }
                }
            });
    });
    //UpdateSellerCommission
    $(document).on('click', '.UpdateSellerCommission', function() {
        var _this = $(this);
        let admin_commission = $(_this).parents('tr').find('.admin_commission').val();//$(_this).find('.admin_commission').val();
        const id = $(this).data('id');
        let isFor = "";
        swal({
                title: "",
                text: "Are you sure? update commission this Seller!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, " + isFor + " it!",
                closeOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        type: "post",
                        url: "{{route('seller-commission-update')}}",
                        data: {
                            id: id,
                            admin_commission: admin_commission,
                        },
                        success: function(data) {
                            if (data.success) {
                                console.log(data.success);
                                if (data.admin_commission) {
                                    $(_this).parents('tr').find('.admin_commission').val(data.admin_commission);
                                } else {
                                   $('.admin_commission').val();
                                }
                            }
                        }
                    });
                } else {
                    $(_this).parents('tr').find('.admin_commission').val('');
                }
            });
    });
</script>
@endsection
