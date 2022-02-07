<?php

namespace App\Http\Controllers\Front;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Products;
use App\Repositories\OrderDetailsRepository;
use App\Repositories\OrdersRepository;
use App\Repositories\OrderStatusHistoryRepository;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Auth;

class PlaceOrdersController extends Controller
{
    private $ordersRepository;
    private $orderDetailsRepository;
    private $orderStatusHistoryRepository;
    private $settingRepository;

    public function __construct(
        OrdersRepository $ordersRepository,
        OrderDetailsRepository $orderDetailsRepository,
        OrderStatusHistoryRepository $orderStatusHistoryRepository,
        SettingRepository $settingRepository
    ) {
        $this->ordersRepository = $ordersRepository;
        $this->orderDetailsRepository = $orderDetailsRepository;
        $this->orderStatusHistoryRepository = $orderStatusHistoryRepository;
        $this->settingRepository = $settingRepository;
        parent::__construct();
    }



    public function checkout(Request $request)
    {

        $shipping_address_id = $request->shipping_address_id;
        $user = Auth()->user();

        header('Content-Type: application/json');
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $orders = $this->placeOrder($shipping_address_id, $user);

        if ($orders == true) {


            $checkout_session = Session::create([
                'customer_email' => $user->email,
                'payment_method_types' => ['card'],
                'client_reference_id' => session()->get('order_id'),
                'line_items' => [
                    $this->lineItems()
                ],
                'mode' => 'payment',
                'success_url' => env('APP_URL') . '/success',
                'cancel_url' => env('APP_URL') . '/cancel',
            ]);
            //returns session id
            return response()->json(['id' => $checkout_session->id]);
        } else {
            return response()->json(['result' => false, 'error' => 'Something went wrong!']);
        }
    }

    private function lineItems()
    {
        $cartItems =  Cart::instance('cart')->content();

        $lineItems = [];
        foreach ($cartItems as $cartItem) {
            $unit_price = $cartItem->price - $cartItem->discount;
            $product['price_data'] = [
                'currency' => 'usd',
                'unit_amount' => $unit_price * 100,
                'product_data' => [
                    'name' => $cartItem->name,
                ],
            ];
            $product['quantity'] = $cartItem->qty;
            $lineItems[] = $product;
        }

        return $lineItems;
    }

    private function placeOrder($shipping_address_id, $user)
    {

        $commission_admin = $this->settingRepository->CommissionAdmin()->value;


        $cart = Cart::instance('cart')->content();

        $seller = array();
        $commission_total = 0;

        foreach ($cart as $cart_val) {
            $products = Products::find($cart_val->id);
            $seller[] = $products->user->id;
                if($products->user->admin_commission){
                    $commission_admin =  $products->user->admin_commission;
                }
            $commission_total += $cart_val->price * $commission_admin / 100;
        }
        $seller = array_unique($seller);

        $sub_total = Cart::subtotal(2, '.', '');
        $total = Cart::total(2, '.', '');
        $total_discount = Cart::discount();
        $latestOrder = Orders::orderBy('created_at', 'DESC')->first();
        $order_id = '0';
        if ($latestOrder != '') {
            $order_id = $latestOrder->id;
        }
        $order_no =  str_pad($order_id + 1, 8, "0", STR_PAD_LEFT);

        $order_data = array();
        $order_data['user_id'] = $user->id;
        $order_data['shipping_address_id'] = $shipping_address_id;
        $order_data['order_no'] = $order_no;
        $order_data['sub_total'] = $sub_total;
        $order_data['total'] = $total;
        $order_data['commission_total'] = $commission_total;
        $order_data['discount'] = $total_discount;
        $order_data['payment_status'] = 'Incomplete';
        $orders = $this->ordersRepository->create($order_data);

        foreach ($cart as $cart_val) {
            $products = Products::find($cart_val->id);

            $commission_total = $cart_val->price * $commission_admin / 100;

            $order_detail_data['order_id'] = $orders->id;
            $order_detail_data['product_id'] = $products->id;
            $order_detail_data['seller_id'] = $products->user->id;
            $order_detail_data['name'] = $products->name;
            $order_detail_data['sku'] = $products->sku;

            if ($cart_val->options->extra_detail['product_type'] == 'Rent') {
                $order_detail_data['sell_type'] = $cart_val->options->extra_detail['product_type'];
                $order_detail_data['from_date'] = $cart_val->options->extra_detail['from_date'];
                $order_detail_data['to_date'] = $cart_val->options->extra_detail['to_date'];
                $order_detail_data['from_time'] = $cart_val->options->extra_detail['from_time'];
                $order_detail_data['to_time'] = $cart_val->options->extra_detail['to_time'];
                $order_detail_data['total_hrs'] = $cart_val->options->extra_detail['total_hrs'];
            }

            $order_detail_data['price'] = $cart_val->price;
            $order_detail_data['quantity'] = $cart_val->qty;
            $order_detail_data['sub_total'] = $cart_val->price * $cart_val->qty;
            $order_detail_data['total'] = $cart_val->price * $cart_val->qty;
            $order_detail_data['commission'] = $commission_admin;
            $order_detail_data['commission_total'] = $commission_total;
            $order_detail_data['discount'] = $cart_val->discount;
            $order_detail = $this->orderDetailsRepository->create($order_detail_data);

            $order_status_history_data['order_detail_id'] = $order_detail->id;
            $order_status_history_data['status_id'] = 1;
            $order_status_history = $this->orderStatusHistoryRepository->create($order_status_history_data);
        }
        session()->put('order_id', $orders->id);

        if ($orders != '') {
            return true;
        } else {
            return false;
        }
    }


    public function success()
    {
        $data = array();

        $order_id = session()->get('order_id');

        if (isset($order_id)) {
            $data['payment_method'] = 'Stripe';
            $data['payment_method_title'] = 'Stripe';
            $data['payment_status'] = 'Succeeded';
            $this->ordersRepository->update($order_id, $data);

            $order = Orders::where('id', $order_id)->first();
            NotificationHelper::placeOrderSuccess($order);
        } else {
            abort(404);
        }

        session()->forget('shipping_address_id');
        session()->forget('order_id');

        Cart::instance('cart')->destroy();


        $return_data['categories'] = $this->categories;

        return view('front.checkout.success', array_merge($data, $return_data));
    }

    public function cancel()
    {
        $data = array();

        $return_data['categories'] = $this->categories;

        return view('front.checkout.cancel', array_merge($data, $return_data));
    }

    public function trackOrder(Request $request)
    {
            $order = Orders::where('order_no', $request->order_number)->first();

            if ($order == null || $order == '') {
                return response()->json(['success' => false, 'message' => 'No Order found ! Please recheck your data']);
            }
            if ($order !== '' || $order !== null) {
                $shippingAddress = $order->shippingAddress;
                $user = $order->user;
                if ($shippingAddress !== '' && $user !== '' && $user->email == $request->email && $shippingAddress->zipcode == $request->zipcode) {
                    $details = $order->orderDetail;
                    $html = '';
                    if (count($details) > 0) {
                        foreach ($details as $key => $value) {
                            $statushistory = $value->orderStatusHistory;
                            $html .= '<div class="od_status_item"><h4 class="od_status_item_title">' . $value->name . '</h4>
                        <ul class="od_status_box" >';
                            foreach ($statushistory as $key1 => $value1) {
                                $html .= '<li class=" complete ">
                            <label for="">' . $value1->OrderStatus->name  . ':</label>
                            <span> ' . date('d-m-Y H:i', strtotime($value1->OrderStatus->created_at)) . '</span></li>';
                            }
                            $html .= '</ul></div>';
                        }
                    }
                    return response()->json(['success' => true, 'message' => 'Tracking details found', 'html' => $html]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Incorrect details ! Please check again']);
                }
            }
    }
}
