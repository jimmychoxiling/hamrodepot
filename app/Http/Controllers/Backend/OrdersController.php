<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Auth;
use App\Models\User;
use Illuminate\Notifications\Notification;

class OrdersController extends Controller
{
    public function index()
    {
        if (Auth::user()->hasRole('Admin')) {
            return view('Backend.orders.index');
        } else {
            return view('Backend.orders.seller-orders-list');
        }
    }

    public function getOrders(Request $request)
    {
        if ($request->ajax()) {
            $data = OrderDetail::with('orders')->latest()->groupBy('order_id')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_no', function ($row) {
                    return '#' . $row->orders->order_no;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->orders->user->name." ".$row->orders->user->last_name;
                })
                ->addColumn('seller_name', function ($row) {
                       $seller_name = User::where('id',$row->seller_id)->first();
                        return $seller_name->name ." ". $seller_name->last_name ;
                })
                ->addColumn('commission_total', function ($row) {
                    return config('constant.CURRENCY_SIGN').$row->orders->commission_total;
                })
                ->addColumn('total', function ($row) {
                    return '$' . $row->orders->total;
                })
                ->addColumn('total_payable', function ($row) {
                    return config('constant.CURRENCY_SIGN'). ($row->orders->total - $row->orders->commission_total);
                })
                ->addColumn('discount', function ($row) {
                    return config('constant.CURRENCY_SIGN'). ($row->orders->discount);
                })
                ->addColumn('status', function ($row) {
                    $class = 'success';
                    if ($row->orderStatusLast->OrderStatus->id == 6) {
                        $class = 'danger';
                    }
                    if ($row->orderStatusLast->OrderStatus->id == 1) {
                        $class = 'warning';
                    }

                    return '<div class="status-main"><span class="order-badge badge badge-pill badge-' . $class . '">' . $row->orderStatusLast->OrderStatus->name . ' </span></div>';
                })
                ->addColumn('payment_status', function ($row) {
                    if ($row->orders->payment_status == 'Succeeded') {
                        $class = 'success';
                    }
                    if ($row->orders->payment_status == 'Incomplete') {
                        $class = 'danger';
                    }

                    return '<div class="status-main"><span class=" badge badge-pill badge-' . $class . '">' . $row->orders->payment_status . ' </span></div>';
                })
                ->addColumn('action', function ($row) {
                    $statusBtn = "";
                    $cancelBtn = "";
                    $confirmDisplay = "none";
                    $processDisplay = "none";
                    $dispatchDisplay = "none";
                    $completeDisplay = "none";
                    if ($row->orderStatusLast->OrderStatus->id == 1) {
                        $confirmDisplay =  'block';
                    } else if ($row->orderStatusLast->OrderStatus->id == 2) {
                        $processDisplay = "block";
                    } else if ($row->orderStatusLast->OrderStatus->id == 3) {
                        $dispatchDisplay = "block";
                    } else if ($row->orderStatusLast->OrderStatus->id == 4) {
                        $completeDisplay = "block";
                    }
                    $statusBtn = '
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Completed" data-status="5" style="display:' . $completeDisplay . ' " class="btn btn-success btn-sm complete-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Complete</a>
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Dispatched" data-status="4" style="display:' . $dispatchDisplay . ' " class="btn btn-primary btn-sm dispatch-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Dispatch</a>
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Processing" data-status="3" style="display:' . $processDisplay . ' " class="btn btn-primary btn-sm process-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Processing</a>
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Confirm" data-status="2" style="display:' . $confirmDisplay . ' " class="btn btn-success btn-sm confirm-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Confirm</a>';
                    if ($row->orderStatusLast->OrderStatus->id !== 5 && $row->orderStatusLast->OrderStatus->id !== 6 && $row->orderStatusLast->OrderStatus->id !== 7 && $row->orderStatusLast->OrderStatus->id !== 8) {
                        $cancelBtn =  '<a href="javascript:void(0);" data-id="' . $row->id . '" data-statsname="Cancel" data-status="6" class="btn btn-danger btn-sm cancel-order statusUpdateOrder"><i class="fa fa-ban"></i> Cancel</a>';
                    }
                    $actionBtn = '<a  class="btn btn-info  btn-sm" href="' . route('orders-detail', $row->orders->id) . '"><i class="fa fa-eye"></i></a>
                                   ';
                    return  $statusBtn . $cancelBtn . $actionBtn;
                })
                ->rawColumns(['status','payment_status', 'action'])
                ->make(true);
        }
    }

    public function orderDetail($id)
    {
        $data = array();

        if (Auth::user()->hasRole('Admin')) {
            $order = Orders::where('id', $id)->first();
            if (empty($order)) {
                abort(404);
            }
            $return_data['order'] = $order;
            return view('Backend.orders.show', array_merge($data, $return_data));
        } else {
            $order = OrderDetail::where('id', $id)->first();
            if (empty($order)) {
                abort(404);
            }
            $return_data['order'] = $order;
            return view('Backend.orders.seller-order-detail', array_merge($data, $return_data));
        }
    }

    public function getOrdersSeller(Request $request)
    {
        if ($request->ajax()) {
            $user_id = Auth::user()->id;
            $data = OrderDetail::with('orders')
                ->whereHas('orders', function ($q) {
                    $q->where('payment_status', 'Succeeded');
                })
                ->where('seller_id', $user_id);

            $data = $data->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_no', function ($row) {
                    return '#' . $row->orders->order_no;
                })
                ->addColumn('user_name', function ($row) {
                    return $row->orders->user->name." ".$row->orders->user->last_name;
                })
                ->addColumn('total', function ($row) {
                    return '$' . $row->total;
                })
                ->addColumn('commission_total', function ($row) {
                    return config('constant.CURRENCY_SIGN').$row->commission_total;
                })
                ->addColumn('total_payable', function ($row) {
                    return config('constant.CURRENCY_SIGN'). ($row->total - $row->commission_total - $row->discount);
                })
                ->addColumn('discount', function ($row) {
                    return config('constant.CURRENCY_SIGN'). ($row->discount);
                })
                ->addColumn('status', function ($row) {
                    $class = 'success';
                    if ($row->orderStatusLast->OrderStatus->id == 6) {
                        $class = 'danger';
                    }
                    if ($row->orderStatusLast->OrderStatus->id == 1) {
                        $class = 'warning';
                    }

                    return '<div class="order-status"><span class="order-badge badge badge-pill badge-' . $class . '">' . $row->orderStatusLast->OrderStatus->name . ' </span></div>';
                })
                ->addColumn('payment_status', function ($row) {
                    if ($row->orders->payment_status == 'Succeeded') {
                        $class = 'success';
                    }
                    if ($row->orders->payment_status == 'Incomplete') {
                        $class = 'danger';
                    }

                    return '<div class="status-main"><span class=" badge badge-pill badge-' . $class . '">' . $row->orders->payment_status . ' </span></div>';
                })
                ->addColumn('action', function ($row) {
                    $statusBtn = "";
                    $cancelBtn = "";
                    $confirmDisplay = "none";
                    $processDisplay = "none";
                    $dispatchDisplay = "none";
                    $completeDisplay = "none";
                    if ($row->orderStatusLast->OrderStatus->id == 1) {
                        $confirmDisplay =  'block';
                    } else if ($row->orderStatusLast->OrderStatus->id == 2) {
                        $processDisplay = "block";
                    } else if ($row->orderStatusLast->OrderStatus->id == 3) {
                        $dispatchDisplay = "block";
                    } else if ($row->orderStatusLast->OrderStatus->id == 4) {
                        $completeDisplay = "block";
                    }
                    $statusBtn = '
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Completed" data-status="5" style="display:' . $completeDisplay . ' " class="btn btn-success btn-sm complete-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Complete</a>
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Dispatched" data-status="4" style="display:' . $dispatchDisplay . ' " class="btn btn-primary btn-sm dispatch-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Dispatch</a>
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Processing" data-status="3" style="display:' . $processDisplay . ' " class="btn btn-primary btn-sm process-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Processing</a>
                    <a href="javascript:void(0);"  data-id="' . $row->id . '" data-statsname="Confirm" data-status="2" style="display:' . $confirmDisplay . ' " class="btn btn-success btn-sm confirm-order statusUpdateOrder"><i class="fa fa-check-circle"></i> Confirm</a>';
                    if ($row->orderStatusLast->OrderStatus->id !== 5 && $row->orderStatusLast->OrderStatus->id !== 6 && $row->orderStatusLast->OrderStatus->id !== 7 && $row->orderStatusLast->OrderStatus->id !== 8) {
                        $cancelBtn =  '<a href="javascript:void(0);" data-id="' . $row->id . '" data-statsname="Cancel" data-status="6" class="btn btn-danger btn-sm cancel-order statusUpdateOrder"><i class="fa fa-ban"></i> Cancel</a>';
                    }
                    $actionBtn = '<a  class="btn btn-info  btn-sm" href="' . route('orders-detail', $row->id) . '"><i class="fa fa-eye"></i></a>
                                   ';
                    return  $statusBtn . $cancelBtn . $actionBtn;
                })
                ->rawColumns(['status','payment_status', 'action'])
                ->make(true);
        }
    }
    public function updateSellerOrderStatus(Request $request)
    {
        $orderStatus = new OrderStatusHistory();
        $detail = OrderDetail::where('id', $request->id)->first();
        $orderStatus->order_detail_id = $request->id;
        $orderStatus->status_id = $request->status;
        $orderStatus->create($orderStatus->toArray());
        $status = $detail->orderStatusLast->OrderStatus;
        $order = Orders::where('id', $detail->order_id)->first();
        NotificationHelper::placeOrderStatus($order, $detail, $status);
        return response()->json(['success' => true, 'message' => '', 'status' => $status]);
    }
}
