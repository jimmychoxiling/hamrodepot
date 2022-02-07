<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Cart;
use Session;

class CartController extends Controller
{
    //
    public function cart()
    {
        $data = array();

        $cart = Cart::instance('cart')->content();
        foreach ($cart as $cart_val) {
            $cart_val->products = Products::find($cart_val->id);
            if($cart_val->products){
            $category = $cart_val->products->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();
            $cart_val->products->slug2 = $category->slug;
            $cart_val->products->slug3 = $sub_category->slug;
            }else{
                $rowId = $cart_val->rowId;
                Cart::remove($rowId);
            }
        }
        $vouchers =  Voucher::all();
        $return_data['categories'] = $this->categories;
        $return_data['vouchers'] = $vouchers;
        $return_data['cart'] = $cart;


        return view('front.cart.cart', array_merge($data, $return_data));
    }

    public function cartAdd(Request $request)
    {
        $pro_id = $request->pro_id;
        $qty = $request->qty;


        $product = Products::find($pro_id);

        $extra_detail = array();
        if ($product->sell_type == 'Rent') {

            $extra_detail['from_date'] = $request->from_date;
            $extra_detail['to_date'] = $request->to_date;
            $extra_detail['from_time'] = $request->from_time;
            $extra_detail['to_time'] = $request->to_time;
            $extra_detail['total_hrs'] = $request->total_hrs;

            $extra_detail['product_type'] = 'Rent';

            $price = $request->total_price;


        } else {

            $extra_detail['product_type'] = 'Buy Now';
            $price = $product->price;
        }

        if ($product->stock >= $qty) {
            $cart = Cart::instance('cart')->add($product->id, $product->name, $qty, $price, 0, ['extra_detail' => $extra_detail]);

            if ($cart != '') {
                return response()->json(['success' => true, 'message' => $product->name . ' added to your cart.', 'cartCount' => Cart::instance('cart')->count()]);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong!']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Out of Stock!']);
        }
    }

    public function cartUpdate(Request $request)
    {
        $rowId = $request->id;
        $pro_id = $request->pro_id;
        $qty = $request->qty;

        $product = Products::find($pro_id);

        if ($product->stock >= $qty) {
            $cart = Cart::instance('cart')->update($rowId, $qty);
            Cart::setGlobalDiscount(0);
            if ($cart != '') {
                return response()->json(['success' => true, 'message' => '', 'subTotal' => Cart::instance('cart')->subtotal(), 'total' => Cart::instance('cart')->total(), 'cartCount' => Cart::instance('cart')->count()]);
            } else {
                return response()->json(['success' => false, 'message' => 'Something went wrong!']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Out of Stock!', 'stock' => $product->stock]);
        }

    }


    public function cartRemove(Request $request)
    {
        if ($request->id && $request->proid) {
            $cart_remove = Cart::instance('cart')->remove($request->id);
            $product = Products::where('id', $request->proid)->first();
            Cart::setGlobalDiscount(0);
            return response()->json(['success' => true, 'message' => $product->name . 'removed from your cart.', 'subTotal' => Cart::instance('cart')->subtotal(), 'total' => Cart::instance('cart')->total(), 'cartCount' => Cart::instance('cart')->count()]);

        } else {
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
    
}
