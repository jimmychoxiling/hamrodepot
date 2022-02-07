<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\Products;
use App\Models\UserAddress;
use App\Repositories\UserAddressRepository;
use Illuminate\Http\Request;
use App\Models\Voucher;
use Cart;


class CheckoutController extends Controller
{
    private $userAddressRepository;

    public function __construct(UserAddressRepository $userAddressRepository)
    {
        $this->userAddressRepository = $userAddressRepository;
        parent::__construct();
    }

    public function checkout()
    {
        $data = array();
        $cart = Cart::instance('cart')->content();

        if(count($cart) == 0){

            return redirect('cart');
        }

        foreach ($cart as $cart_val) {
            $cart_val->products = Products::find($cart_val->id);
            $category = $cart_val->products->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();
            $cart_val->products->slug2 = $category->slug;
            $cart_val->products->slug3 = $sub_category->slug;
        }

        $countries = Country::get();


        $shipping_address = UserAddress::where('default_address','!=','3')->where('user_id',Auth()->user()->id)->orderBy('default_address','DESC')->get();


        $return_data['categories'] = $this->categories;
        $return_data['cart'] = $cart;
        $return_data['countries'] = $countries;
        $return_data['shipping_address'] = $shipping_address;


        return view('front.checkout.checkout', array_merge($data, $return_data));
    }

    public function shippingDetailSave(Request $request)
    {
        $data = $request->all();

        $data['user_id'] = Auth()->user()->id;
        $data['default_address'] = isset($data['default_address']) ? $data['default_address'] : '0';
        $data_default['default_address'] = 0;

        if($data['shipping_id'] != ''){
            $shipping_address_val = $this->userAddressRepository->update($data['shipping_id'], $data);
            $update = 1;
            if($data['default_address'] == '1') {
                $user_addres_update_default = UserAddress::where('id', '!=', $shipping_address_val->id)->where('user_id', $data['user_id'])
                    ->update($data_default);
            }
            return response()->json(['success' => true,'update' => $update,'message' => 'Updated Successfully']);

        }else{
            $shipping_address_val = $this->userAddressRepository->create($data);
            if($data['default_address'] == '1') {
                $user_addres_update_default = UserAddress::where('id', '!=', $shipping_address_val->id)->where('user_id', $data['user_id'])
                    ->update($data_default);
            }

            $view = view('front.checkout.shipping-address', compact('shipping_address_val'))->render();
            $update = 0;
            return response()->json(['success' => true,'html' => $view,'update' => $update,'message' => 'Added Successfully']);

        }



//        return response()->json(['success' => true, 'message' => 'Saved Successfully.']);

    }

    public function shippingAddressDelete($id)
    {
        $data['default_address'] = '3';
      //  $shipping_address = $this->userAddressRepository->update($id, $data);
        $category = $this->userAddressRepository->delete($id);


        return redirect()->route('checkout')
            ->with('success', 'Deleted successfully');
    }

    public function EditShippingAddressFetch(Request $request)
    {

        $shippingAddress = UserAddress::where('id',$request->id)->first();

        return response()->json(['shippingAddress' => $shippingAddress]);
    }
    public function cartOfferApply(Request $request)
    {

         $voucher = Voucher::where('code',$request->offer_code)->where('status',1)->first();
         $card_total =  str_replace( ',', '',$request->cart_total);
         $cart = Cart::instance('cart')->content();
         
        if($voucher){
            $currentDate = date('Y-m-d');
            if(Cart::discountFloat() == 0) {
            if (($currentDate >= $voucher->starts_at) && ($currentDate <= $voucher->expires_at) 
            && (float)$card_total > (float)$voucher->order_amount){
                    foreach ($cart as $key => $value) {
                        Cart::setDiscount($value->rowId, (int)$voucher->discount_amount);
                    }
                    return   Cart::discount();
            }elseif(($voucher->starts_at == NULL) && ($voucher->expires_at == NULL) 
            && (float)$card_total > (float)$voucher->order_amount){
                foreach ($cart as $key => $value) {
                    Cart::setDiscount($value->rowId, (int)$voucher->discount_amount);
                }
                return   Cart::discount();
            }
          }
        }
         return "invalid";
    }
    public function cartOfferCancel(Request $request){

        
        $cart = Cart::instance('cart')->content();
        foreach($cart as $cart){

            $cart = Cart::instance('cart')->update($cart->rowId, ['subtotal'=>$cart->price,'discount'=>0.00]);
            
        }
        return Cart::instance('cart')->content();

    }
}
