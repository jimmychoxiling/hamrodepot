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
                            <li class="breadcrumb-item active" aria-current="page">Discount Coupons</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('voucher-create') }}" class="btn btn-sm btn-neutral">Add New Discount Coupons</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col">
            <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Discount Coupons</h3>
                </div>
                <div class="card-body">
                    @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @elseif($message = Session::get('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
                        <table class="table align-items-center table-flush yajra-datatable" id="voucher-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">order_amount</th>  
                                    <th scope="col">discount_amount</th>  
                                    <th scope="col">starts_at</th>  
                                    <th scope="col">expires_at</th>  
                                    <th scope="col">code</th>  
                                    <th scope="col">status</th>
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
    $('#voucher-datatable').DataTable({
        ajax: {
            type: 'POST',
            url: "{{ route('getVoucher-datatable')}}"
        },
        processing: true,
        serverSide: true,
        columns: [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex'
            },
            {
                data: 'name',
                name: 'Name'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'order_amount',
                name: 'order_amount'
            },
            {
                data: 'discount_amount',
                name: 'discount_amount'
            },
            {
                data: 'starts_at',
                name: 'starts_at'
            },
            {
                data: 'expires_at',
                name: 'expires_at'
            },
            {
                data: 'code',
                name: 'code'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            }
        ]
    });

    $(document).on('click', '.statusUpdateVoucher', function() {
        var _this = $(this);
        let status = $(this).data('status');
        const id = $(this).data('id');
        let isFor = "";
        if (_this.hasClass('approve-status') || (_this.hasClass('active-inactive') && _this.is(":checked"))) {
            status = 1;
            isFor = 'Active';
        } else if (_this.hasClass('reject-status')) {
            status = 3;
            isFor = 'Reject';
        } else {
            status = 2;
            isFor = 'Inactive';
        }
        swal({
                title: "",
                text: "Are you sure? " + isFor + " this Voucher!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, " + isFor + " it!",
                closeOnConfirm: true
            },
            function(isConfirm) {
                if(isConfirm) {
                $.ajax({
                    type: "post",
                    url: "{{route('voucher-status-update')}}",
                    data: {
                        id: id,
                        status: status,
                    },
                    success: function(data) {
                        if (data.success) {
                            if (data.status == 1) {
                                $(_this).parents('tr').find('.active-inactive').prop('checked', true);
                                $(_this).parents('tr').find('.voucher-badge').removeClass('badge-warning badge-danger').addClass('badge-success');
                                $(_this).parents('tr').find('.voucher-badge').text('Active');
                                $(_this).parents('tr').find(".approve-status").hide();
                                $(_this).parents('tr').find(".reject-status").hide();
                                $(_this).parents('tr').find(".custom-toggle").show();
                            } else if (data.status == 0 || data.status == 3) {
                                if (data.status == 0) {
                                    $(_this).parents('tr').find('.voucher-badge').removeClass('badge-danger badge-success').addClass('badge-warning');
                                    $(_this).parents('tr').find('.voucher-badge').text('Pending');
                                } else {
                                    $(_this).parents('tr').find('.voucher-badge').removeClass('badge-warning badge-success').addClass('badge-danger');
                                    $(_this).parents('tr').find('.voucher-badge').text('Reject');
                                }
                                // $(_this).parents('tr').find(".approve-status").hide();
                                $(_this).parents('tr').find(".reject-status").hide();
                                // $(_this).parents('tr').find(".custom-toggle").show();
                            } else {
                                $(_this).parents('tr').find('.active-inactive').prop('checked', false);
                                $(_this).parents('tr').find('.voucher-badge').removeClass('badge-warning badge-success').addClass('badge-danger');
                                $(_this).parents('tr').find('.voucher-badge').text('In-Active');
                            }
                        }
                    }
                });
            } else {
                if(_this.hasClass('active-inactive') && _this.is(":checked")) {
                    $(_this).parents('tr').find('.active-inactive').prop('checked', false);
                } else {
                    $(_this).parents('tr').find('.active-inactive').prop('checked', true);
                }
               }
            });
    });

    
</script>
@endsection