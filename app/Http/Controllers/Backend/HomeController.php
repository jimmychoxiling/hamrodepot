<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Products;
use App\Models\User;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $report_counts = array();
        if (Auth::user()->hasRole('Admin')) {
            $report_counts['total_sellers'] = User::where('status', '1')->whereHas('roles', function ($q) {
                return $q->where('name', 'Seller');
            })->count();
            $report_counts['total_users'] = User::where('status', '1')->whereHas('roles', function ($q) {
                return $q->where('name', 'User');
            })->count();
            $report_counts['total_sales'] = OrderDetail::sum('total');
            $report_counts['total_commission'] = OrderDetail::sum('commission_total');
            $report_counts['total_seller_amt'] = $report_counts['total_sales'] - $report_counts['total_commission'];
            $topSeller = OrderDetail::select(DB::raw('sum(total) as `totalcount`', 'seller_id'), DB::raw('seller_id'))->groupBy('seller_id')->orderBy('totalcount', 'DESC')->limit(10)->get();
            $topProducts = OrderDetail::select(DB::raw('sum(total) as `totalcount`', 'product_id'), DB::raw('product_id'))->groupBy('product_id')->orderBy('totalcount', 'DESC')->limit(10)->get();
        } else {
            $report_counts['total_sales'] = OrderDetail::where('seller_id', auth()->user()->id)->sum('total');
            $report_counts['total_commission'] = OrderDetail::where('seller_id', auth()->user()->id)->sum('commission_total');
            $report_counts['total_seller_amt'] = $report_counts['total_sales'] - $report_counts['total_commission'];
            $topSeller = OrderDetail::select(DB::raw('sum(total) as `totalcount`', 'seller_id'), DB::raw('seller_id'))->where('seller_id', auth()->user()->id)->groupBy('seller_id')->orderBy('totalcount', 'DESC')->limit(10)->get();
            $topProducts = OrderDetail::select(DB::raw('sum(total) as `totalcount`', 'product_id'), DB::raw('product_id'))->where('seller_id', auth()->user()->id)->groupBy('product_id')->orderBy('totalcount', 'DESC')->limit(10)->get();
        }

        $topBrands = $topProducts->mapToGroups(function ($item, $key) {
            if($item->product)
            return [$item->product->brand->name => $item->totalcount];
            else{
                return [];
            }
        });
        foreach ($topBrands as $key => $value) {
            $totals = array();
            foreach ($value as $key1 => $value1) {
                array_push($totals, $value1);
            }
            $value['totalcount'] = array_sum($totals);
            $value['name'] = $key;
        }
        // dd($topBrands);
        return view('Backend.dashboard', compact('report_counts', 'topSeller', 'topProducts', 'topBrands'));
    }

    public function getTotalOrders()
    {
        $year = date("Y");
        if(Auth::user()->hasrole('Admin')) {
        $total_orders = Orders::select(DB::raw('count(id) as `total`'), DB::raw('MONTH(created_at) month'))
            ->where(DB::raw('YEAR(created_at)'), '=', $year)->groupby('month')
            ->get();
        } else {
            $total_orders = OrderDetail::select(DB::raw('count(order_id) as `total`'), DB::raw('MONTH(created_at) month'))
            ->where(DB::raw('YEAR(created_at)'), '=', $year)->groupby('month')->groupby('order_id')->where('seller_id', auth()->user()->id)
            ->get();
        }
        return response()->json(['success' => true, 'total_orders' => $total_orders]);
    }

    public function getTotalSales()
    {
        $year = date("Y");
        if(Auth::user()->hasrole('Admin')) {
        $total_sales = OrderDetail::select(DB::raw('sum(total) as `total`'), DB::raw('MONTH(created_at) month'))
            ->where(DB::raw('YEAR(created_at)'), '=', $year)->groupby('month')
            ->get();
        } else {
            $total_sales = OrderDetail::select(DB::raw('sum(total) as `total`'), DB::raw('MONTH(created_at) month'))
            ->where(DB::raw('YEAR(created_at)'), '=', $year)->groupby('month')->where('seller_id', auth()->user()->id)
            ->get();
        }
        return response()->json(['success' => true, 'total_sales' => $total_sales]);
    }
}
