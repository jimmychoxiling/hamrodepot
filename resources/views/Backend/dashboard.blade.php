@extends('Backend.layouts.app')

@section('content')
@include('Backend.layouts.headers.cards')

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-6 mb-5 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1">Overview</h6>
                            <h2 class="text-white mb-0">Sales value</h2>
                        </div>
                        <div class="col">
                            <!-- <ul class="nav nav-pills justify-content-end">
                                <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 10, 30, 15, 40, 20, 60, 60]}]}}' data-prefix="$" data-suffix="k">
                                    <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                        <span class="d-none d-md-block">Month</span>
                                        <span class="d-md-none">M</span>
                                    </a>
                                </li>
                                <li class="nav-item" data-toggle="chart" data-target="#chart-sales" data-update='{"data":{"datasets":[{"data":[0, 20, 5, 25, 10, 30, 15, 40, 40]}]}}' data-prefix="$" data-suffix="k">
                                    <a href="#" class="nav-link py-2 px-3" data-toggle="tab">
                                        <span class="d-none d-md-block">Week</span>
                                        <span class="d-md-none">W</span>
                                    </a>
                                </li>
                            </ul> -->
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <!-- Chart wrapper -->
                        <canvas id="chart-sales" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Performance</h6>
                            <h2 class="mb-0">Total orders</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="chart-orders" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
    @role('Admin')
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Top Sellers</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{route('seller')}}" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Business name</th>
                                <th scope="col">Total Sale</th>
                                <!-- <th scope="col">Bounce rate</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topSeller as $seller)
                            <tr>
                                <th scope="row">
                                    {{$seller->user->name}} {{$seller->user->last_name}}
                                </th>
                                <td>
                                    {{$seller->user->business_name}}
                                </td>
                                <td>
                                {{ config('constant.CURRENCY_SIGN') }}{{$seller->totalcount}}
                                </td>
                                <!-- <td>
                                    <i class="fas fa-arrow-up text-success mr-3"></i> 46,53%
                                </td> -->
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endrole
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Top Brands</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('brand') }}" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Total sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topBrands as $brand)
                            @if($brand['totalcount'])
                            <tr>
                                <th scope="row">
                                    {{$brand['name']}}
                                </th>
                                <td>
                                {{ config('constant.CURRENCY_SIGN') }}{{$brand['totalcount']}}
                                </td>
                                <!-- <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">60%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td> -->
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="@if(Auth::user()->hasrole('Admin')) col-xl-12 mt-5 @else col-xl-8 @endif  mb-xl-0">
            <div class="card shadow">
                <div class="card-header border-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h3 class="mb-0">Top Products</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('products') }}" class="btn btn-sm btn-primary">See all</a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- Projects table -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Sell Type</th>
                                <th scope="col">Total sales</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topProducts as $product)
                            @if($product->product && $product->product->deleted_at == null)
                            <tr>
                                <th scope="row">
                                    {{$product->product->name}}
                                </th>
                                <td>
                                {{ config('constant.CURRENCY_SIGN') }}{{$product->product->price}}
                                </td>
                                <td>
                                    {{$product->product->sell_type}}
                                </td>
                                <td>
                                {{ config('constant.CURRENCY_SIGN') }}{{$product->totalcount}}
                                </td>
                                <!-- <td>
                                    <div class="d-flex align-items-center">
                                        <span class="mr-2">60%</span>
                                        <div>
                                            <div class="progress">
                                                <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </td> -->
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('Backend.layouts.footers.auth')
</div>
@endsection

@push('js')
<script>
    let orderReportUrl = 'reports-total-order';
    let saleReportUrl = 'reports-total-sales';
    <?php 
    if(Auth::user()->hasrole('Seller')) {
    ?>
    orderReportUrl = 'seller-reports-total-order';
    saleReportUrl = 'seller-reports-total-sales';
    <?php }?>
    let orderdata = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    let salesdata = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    let monthLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const currentMonth = new Date().getMonth();
    monthLabel = monthLabel.slice(0, currentMonth + 1);
    $(document).ready(function() {
        getTotalOrders();
        getTotalSales();
    });
    
    function getTotalOrders() {
        $.ajax({
            type: "get",
            url: orderReportUrl,
            data: {},
            success: function(data) {
                if (data.success) {
                    if (data.total_orders.length) {
                        data.total_orders.forEach((element) => {
                            if (element.month > 0) {
                                orderdata[element.month - 1] = element.total;
                            }
                            console.log(OrdersChart);
                        });
                    }
                }
            }
        });
    }

    function getTotalSales() {
        $.ajax({
            type: "get",
            url: saleReportUrl,
            data: {},
            success: function(data) {
                if (data.success) {
                    if (data.total_sales.length) {
                        data.total_sales.forEach((element) => {
                            if (element.month > 0) {
                                salesdata[element.month - 1] = element.total;
                            }
                         });
                    }
                }
            }
        });
    }
</script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.min.js"></script>
<script src="{{ asset('argon') }}/vendor/chart.js/dist/Chart.extension.js"></script>
@endpush