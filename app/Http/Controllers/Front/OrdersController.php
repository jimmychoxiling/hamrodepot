<?php

namespace App\Http\Controllers\Front;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\OrderStatusHistory;
use Yajra\DataTables\DataTables;

class OrdersController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function orders()
    {
        $data = array();
        $all_order = Orders::where('payment_status','Succeeded')->where('user_id', auth()->user()->id)->count();
        $return_data['categories'] = $this->categories;
        $return_data['all_order'] = $all_order;
        return view('front.orders.orders', array_merge($data, $return_data));

    }

    public function getOrder(Request $request)
    {
        if ($request->ajax()) {
            $data = Orders::where('payment_status','Succeeded')->where('user_id', auth()->user()->id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_no', function ($row) {
                    return '#'.$row->order_no;
                })
                ->addColumn('total', function ($row) {
                    return '$'.$row->total;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('order-detail', $row->id) . '"><i class="fa fa-eye"></i></a>
                                   ';
                    if($row['receipt_url'] != ''){
                        $actionBtn .= '<a href="' . $row['receipt_url'] . '"  target="_blank"><i class="fa fa-file"></i></a>
                                   ';
                    }

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    public function orderDetail($id)
    {

        $data = array();

        $order = Orders::where('id',$id)->first();
        if(empty($order)){
            abort(404);
        }

        foreach ($order->orderDetail as $orderDetail){
            $category = $orderDetail->product->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();

            $orderDetail->product->category = $category;
            $orderDetail->product->sub_category = $sub_category;
        }

        $return_data['categories'] = $this->categories;
        $return_data['order'] = $order;
        return view('front.orders.order-detail', array_merge($data, $return_data));
    }

    public function orderCancel($id)
    {
        $data = array();
        $orderStatus = new OrderStatusHistory();
        $detail = OrderDetail::where('id', $id)->first();
        if($detail->orderStatusLast->status_id == 5) {
            return response()->json(['message'=> 'Your order is completed should not be cancled', 'success' => false]);

        }
        $orderStatus->order_detail_id = $id;
        $orderStatus->status_id = 6;
        $orderStatus->create($orderStatus->toArray());
        $status = $detail->orderStatusLast->OrderStatus;
        $order = Orders::where('id',$detail->order_id)->first();
        foreach ($order->orderDetail as $orderDetail){
            $category = $orderDetail->product->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();

            $orderDetail->product->category = $category;
            $orderDetail->product->sub_category = $sub_category;
        }
        NotificationHelper::placeOrderStatus($order, $detail, $status);
        $view = '';
        foreach($detail->orderStatusHistory as $orderStatusHistory_val) {
            $view .= '<li class="complete">
            <label for="">'. $orderStatusHistory_val->OrderStatus->name .'
                :</label>
            <span>'. date('m-d-Y H:i', strtotime($orderStatusHistory_val->created_at)) .'</span>
        </li>';
    }


        // $view = view('front.orders.order-detail', compact('categories', 'order'))->render();
        return response()->json(['html' => $view, 'detail' => $detail,  'message'=> 'Product cancel successfully', 'success' => true]);
    }
}
