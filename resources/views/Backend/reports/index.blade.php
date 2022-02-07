@extends('Backend.layouts.app', ['title' => __('Products')])

@section('content')
<div class="header bg-primary pb-6 pt-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Reports</li>
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
            <div class="card off-bg">
                <!-- Card header -->
                <div class="card-header border-0">
                    <h3 class="mb-0">Reports</h3>
                </div>
                <div class="card-body">
                    <form method="post" action="" id="reportsForm" autocomplete="off" data-parsley-validate="">
                        <div class="row">
                            @role('Admin')
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-countries_id">Sellers</label>
                                    <select name="seller_id" id="seller_id" class="form-control form-control-alternative">
                                        <option value="">Select Seller</option>
                                        @foreach($sellers as $saller_val)
                                        <option value="{{$saller_val->id}}">{{$saller_val->name}} {{$saller_val->last_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endrole
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="input-countries_id">Products</label>
                                    <select name="product_id" id="product_id" class="form-control form-control-alternative">
                                        <option value="">Select Products</option>
                                        @foreach($products as $product_val)
                                        <option value="{{$product_val->id}}">{{$product_val->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="from_date">From</label>
                                    <input type="date" name="from_date" class="form-control form-control-alternative reportDate" placeholder="From Date" id="from_date" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="form-control-label" for="to_date">To</label>
                                    <input type="date" name="to_date" id="to_date" class="form-control form-control-alternative reportDate" placeholder="To date" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-success mt-4 get_report">Get Reports</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- Light table -->
                    @include('Backend.reports.cards')


                    <!-- Light table -->
                    <div class="table-responsive mt-5">
                        <table class="table align-items-center table-flush yajra-datatable" id="report-product-datatable">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Sell Type</th>
                                    <th scope="col">Total Sales</th>
                                </tr>
                            </thead>
                            <tbody id="report-product-table-body">
                                <tr>
                                    <td colspan="4" class="text-center"> No record found!</td>
                                </tr>
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
<script>
    $(document).ready(function() {
        var date = new Date();
        let firstDay = moment(new Date(date.getFullYear(), date.getMonth(), 1)).format('YYYY-MM-DD');
        let lastDay = moment(new Date(date.getFullYear(), date.getMonth() + 1, 0)).format('YYYY-MM-DD');
        $('#from_date').val(firstDay);
        $('#to_date').val(lastDay);
        $('#seller_id').on('change', function() {
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "post",
                url: "{{ route('seller-products')}}",
                data: {
                    _token: CSRF_TOKEN,
                    seller_id: $(this).val()
                },
                success: function(data) {
                    $('#product_id').html('');
                    $('#product_id').html(data.html);
                }
            });
        });
        $('#reportsForm').on('submit', function(e) {
            e.preventDefault();
            if ($(this).parsley().isValid()) {
                var frm = $(this).serialize();
                reports();
            }
        });

        function reports() {
            $.ajax({
                type: "post",
                url: "{{route('get-reports')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    seller_id: $('#seller_id').val(), 
                    product_id: $('#product_id').val(), 
                    from_date: $('#from_date').val() + ' 00:00:00',
                    to_date: $('#to_date').val() + ' 23:59:59',
                },
                success: function(data) {
                    $('#report-product-table-body').html(data.html);
                    $('#total_commission').text('$ ' + data.report_counts.total_commission);
                    $('#total_sales').text('$ ' + data.report_counts.total_sales);
                    $('#total_seller_amt').text('$ ' + data.report_counts.total_seller_amt);
                }
            });
        }
        $('.reportDate').on('change', function() {
            from_date = $("#from_date").val();
            to_date = $("#to_date").val();
            fromDate = moment(from_date);
            toDate = moment(to_date);
            if (fromDate && toDate && !toDate.isSameOrAfter(fromDate)) {
                if (fromDate) {
                    $("#to_date").val(fromDate.format('YYYY-MM-DD'));
                } else {
                    $("#to_date").val(today.format('YYYY-MM-DD'));
                }
            }
        });
    });
</script>
@endsection