<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Products;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class ReportsController extends Controller
{
    public function index()
    {
        $sellers = User::where('status', '1')->whereHas('roles', function ($q) {
            return $q->where('name', 'Seller');
        })->get();
        $products = Products::where('status', '1')->get();
        if (Auth::user()->hasrole('Seller')) {
            $products = Products::where('status', '1')->where('seller_id', auth()->user()->id)->get();
        }
        return view('Backend.reports.index', compact('sellers', 'products'));
    }

    public function getSellerProducts(Request $request)
    {
        $html = '';
        if (isset($request->seller_id)) {
            $products = Products::where('status', '1')->where('seller_id', $request->seller_id)->get();
        } else {
            $products = Products::where('status', '1')->get();
        }
        if (count($products) > 0) {
            $html .= '<option value="">Select Product </option>';
            foreach ($products as $product_val) {
                $html .= '<option value="' . $product_val->id . '">';
                $product_name = $product_val->name;
                $html .= $product_name . '</option>';
            }
        } else {
            $html .= '<option value="">Choose Product</option>';
        }
        return response()->json(['html' => $html]);
    }

    public function getReports(Request $request)
    {
        $seller_id = '';
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if (Auth::user()->hasrole('Seller')) {
            $seller_id = auth()->user()->id;
        }
        if (isset($request->seller_id)) {
            $seller_id = $request->seller_id;
        }
        $report_counts['total_sales'] = OrderDetail::whereBetween('created_at', [$from_date, $to_date])->sum('total');
        $report_counts['total_commission'] = OrderDetail::whereBetween('created_at', [$from_date, $to_date])->sum('commission_total');
        $topProducts = OrderDetail::select(DB::raw('sum(total) as `totalcount`', 'product_id'), DB::raw('product_id'))->whereBetween('created_at', [$from_date, $to_date])->groupBy('product_id')->orderBy('totalcount', 'DESC');
        if ($seller_id !== '') {
            $report_counts['total_sales'] = OrderDetail::whereBetween('created_at', [$from_date, $to_date])->where('seller_id', $seller_id)->sum('total');
            $report_counts['total_commission'] = OrderDetail::whereBetween('created_at', [$from_date, $to_date])->where('seller_id', $seller_id)->sum('commission_total');
            $topProducts = $topProducts->where('seller_id', $seller_id);
        }
        if (isset($request->product_id)) {
            $product_id = $request->product_id;
            $report_counts['total_sales'] = OrderDetail::whereBetween('created_at', [$from_date, $to_date])->where('product_id', $product_id)->sum('total');
            $report_counts['total_commission'] = OrderDetail::whereBetween('created_at', [$from_date, $to_date])->where('product_id', $product_id)->sum('commission_total');
            $topProducts = $topProducts->where('product_id', $product_id);
        }
        $report_counts['total_seller_amt'] = round($report_counts['total_sales'] - $report_counts['total_commission'], 2);
        $topProducts = $topProducts->get();
        $html = '';

        if (count($topProducts) > 0) {
            foreach ($topProducts as $product) {
                $html .= ' <tr>
            <td>' .
                    $product->product->name
                    . ' </th>
            <td>
            $' . $product->product->price .
                    '</td>
            <td>' .
                    $product->product->sell_type
                    . '</td>
            <td>
            $' . $product->totalcount
                    . '</td>
            </tr>';
            }
        } else {
            $html .= ' <tr > <td colspan="4" class="text-center"> No record found!</td> </tr>';
        }
        return response()->json(['html' => $html, 'report_counts' => $report_counts]);
    }
}
