<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductWishlist;
use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    private $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function wishList()
    {
        if (Auth::check()) {
            $data = array();
            $wishlist_products = ProductWishlist::where('user_id', auth()->user()->id)->get();
            foreach ($wishlist_products as $key => $wishlist_product) {
                $category = $wishlist_product->product->categories()->first();
                $sub_category = Category::where('parent_id', '=', $category->id)->first();
                $wishlist_product->product->slug2 = $category->slug;
                $wishlist_product->product->slug3 = $sub_category->slug;
                $ratingData = $this->productRepository->getAvgProductRating($wishlist_product->product_id);
                $wishlist_product->avg_rating = $ratingData->avg_rating;
                $wishlist_product->all_rating = $ratingData->all_ratings;
            }
            $return_data['categories'] = $this->categories;
            $return_data['wishlist_products'] = $wishlist_products;
            $return_data['categories'] = $this->categories;

            return view('front.my-account.wishlist', array_merge($data, $return_data));
        } else {

        }
    }

    public function wishlistAddRemove(Request $request)
    {

        if (Auth::check()) {
            if (Auth::user()->hasRole('User')) {
                $pro_id = $request->pro_id;
                $user_id = Auth()->user()->id;

                $product_wishlist = ProductWishlist::where('user_id', $user_id)->where('product_id', $pro_id)->first();
                $product = Products::where('id', $pro_id)->first(); 

                if ($product_wishlist == '') {

                    $data['user_id'] = $user_id;
                    $data['product_id'] = $pro_id;
                    $wishlist_add = ProductWishlist::create($data);
                    $count_wishlist = (new \App\Helpers\Helper)->wishlistCountUser();
                    return response()->json(['success' => true, 'message' => $product->name . ' added to your wishlist.', 'wishlistCount' => $count_wishlist, 'wishlistCheck' => true]);
                } else {
                    $wishlist_remove = ProductWishlist::where('user_id', $user_id)->where('product_id', $pro_id)->delete();
                    $count_wishlist = (new \App\Helpers\Helper)->wishlistCountUser();
                    return response()->json(['success' => true, 'message' => $product->name . ' removed from your wishlist.', 'wishlistCount' => $count_wishlist, 'wishlistCheck' => false]);
                }

            } else {
                return response()->json(['success' => false, 'message' => 'Not Permission to Product add in wishlist']);

            }
        } else {
            return response()->json(['success' => false, 'not_authenticate' => true, 'message' => 'Please Login after product add to wishlist']);
        }
    }
}
