@extends('Backend.layouts.app', ['title' => __('Orders')])

@section('content')

    <!-- <div class="header bg-primary pb-6 pt-6">
        <div class="container-fluid">
            <div class="header-body">
                <div class="row align-items-center py-4">
                    <div class="col-lg-6 col-7">
                        <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                            <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">Orders</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8 dashboard_card">
        <div class="container-fluid">
            <div class="header-body">
                <!-- Card stats -->
                <div class="row c_row">
                @role('Admin')
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-stats mb-4 mb-xl-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Late Order</h5>
                                        <span class="h2 font-weight-bold mb-0">10</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                    <span class="text-nowrap">Since yesterday</span>
                                </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-stats mb-4 mb-xl-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Order Due Today</h5>
                                        <span class="h2 font-weight-bold mb-0">0</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-red text-white rounded-circle shadow">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                    <span class="text-nowrap">Since yesterday</span>
                                </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-stats mb-4 mb-xl-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">New Order</h5>
                                        <span class="h2 font-weight-bold mb-0">4</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-green text-white rounded-circle shadow">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                    <span class="text-nowrap">Since yesterday</span>
                                </p> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-12">
                        <div class="card card-stats mb-4 mb-xl-1">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">Past Order</h5>
                                        <span class="h2 font-weight-bold mb-0">10K</span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="icon icon-shape bg-blue text-white rounded-circle shadow">
                                            <i class="fas fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- <p class="mt-3 mb-0 text-muted text-sm">
                                    <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> 1.10%</span>
                                    <span class="text-nowrap">Since yesterday</span>
                                </p> -->
                            </div>
                        </div>
                    </div>
                    @endrole
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
                        <h3 class="mb-0">Orders</h3>
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
                                   id="order-datatable">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Sr.No</th>
                                    <th scope="col">Order Id</th>
                                    <th scope="col">User Name</th>
                                    <th scope="col">Seller Name</th>
                                    <th scope="col">Grand Total</th>
                                    <th scope="col">commission_total</th>
                                    <th scope="col">Seller Amount</th>
                                    <th scope="col">Discount</th>
                                    <th scope="col">order Status</th>
                                    <th scope="col">Payment Status</th>
                                    <th scope="col">Date</th>
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

        $('#order-datatable').DataTable({
            ajax: {
                type: 'POST',
                url: "{{ route('getOrders-datatable')}}"
            },
            processing: true,
            serverSide: true,
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {
                    data: 'order_no',
                    name: 'order_no'
                },
                {
                    data: 'user_name',
                    name: 'user_name'
                },
                {
                    data: 'seller_name',
                    name: 'seller_name'
                },
                {
                    data: 'total',
                    name: 'total'
                },
                {
                    data: 'commission_total',
                    name: 'commission_total'
                },
                {
                    data: 'total_payable',
                    name: 'total_payable'
                },
                {
                    data: 'discount',
                    name: 'discount'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function (data) {
                        if (data === undefined) {
                            return null;
                        } else {

                            return formatDate(data);
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                }
            ]
        });
        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();
            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [month, day, year].join('-');
        }
        $(document).on('click', '.statusUpdateOrder', function() {
        var _this = $(this);
        let status = $(this).data('status');
        let statsname = $(this).data('statsname');
        let id = $(this).data('id');
        swal({
                title: "",
                text: "Are you sure? " + statsname + " of this Order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, update it!",
                closeOnConfirm: true
            },
            function(isConfirm) {
                if (isConfirm) {
                    $('#order-datatable').addClass('section-loader');
                    $.ajax({
                        type: "post",
                        url: "{{route('order-status')}}",
                        data: {
                            id: id,
                            status: status,
                        },
                        success: function(data) {
                            if (data.success) {
                                if (data.status.id == 2) {
                                    $(_this).parents('tr').find(".confirm-order").hide();
                                    $(_this).parents('tr').find(".process-order").show();
                                    $(_this).parents('tr').find('.order-badge').removeClass('badge-warning badge-danger').addClass('badge-success');
                                } else if (data.status.id == 3) {
                                    $(_this).parents('tr').find(".process-order").hide();
                                    $(_this).parents('tr').find(".dispatch-order").show();
                                } else if (data.status.id == 4) {
                                    $(_this).parents('tr').find(".dispatch-order").hide();
                                    $(_this).parents('tr').find(".complete-order").show();
                                } else if (data.status.id == 5) {
                                    $(_this).parents('tr').find(".complete-order").hide();
                                    $(_this).parents('tr').find(".cancel-order").hide();
                                    $(_this).parents('tr').find('.order-badge').removeClass('badge-warning badge-danger').addClass('badge-success');
                                } else {
                                    $(_this).parents('tr').find(".dispatch-order").hide();
                                    $(_this).parents('tr').find(".process-order").hide();
                                    $(_this).parents('tr').find(".confirm-order").hide();
                                    $(_this).parents('tr').find(".complete-order").hide();
                                }
                                if (data.status.id == 6) {
                                    $(_this).parents('tr').find(".cancel-order").hide();
                                    $(_this).parents('tr').find('.order-badge').removeClass('badge-success badge-warning').addClass('badge-danger');
                                }
                                $(_this).parents('tr').find(".order-badge").text(data.status.name);
                            }
                            // location.href = "{{route('brand')}}";
                            $('#order-datatable').removeClass('section-loader');
                        }
                    });
                } else {

                }
            });
    });


    </script>
@endsection
