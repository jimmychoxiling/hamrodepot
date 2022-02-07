<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductRating;
use App\Models\Products;
use App\Models\ProductWishlist;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;

class ProductDetailController extends Controller
{
    private $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }
    public function index(Request $request, $slug2 = null, $slug3 = null, $slug4 = null, $slug5 = null)
    {
        $data = array();

        $category = Category::where('parent_id', '=', null)->where('level', '=', 1)->where('slug', $slug2)->first();

        if (empty($category)) {
            abort(404);
        }

        $sub_category = Category::where('parent_id', '!=', null)->where('level', '=', 2)->where('slug', $slug3)->first();

        if (empty($sub_category)) {
            abort(404);
        }

        if ($slug4 !== null && $slug5 == null) {
            $type = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('slug', $slug4)->first();
            if (!empty($type)) {
                return redirect()->action(
                    [ProductController::class, 'index'],
                    ['slug2' => $category->slug,
                    'slug3' => $sub_category->slug,
                    'slug4' => $slug4,
                    ]
                ); 
            } else {
                $product = Products::where('status', '1')->where('slug', $slug4)->first();
                if (empty($product)) {
                    abort(404);
                }
            }
        } 
        if ($slug4 !== null && $slug5 !== null) {
            $type = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('slug', $slug4)->first();
            if (empty($type)) {
                abort(404);
            }
            $product = Products::where('status', '1')->where('slug', $slug5)->first();
            if (empty($product)) {
                abort(404);
            }
        }

        
        $product->wishlistCheck = false;
        if (Auth::check()) {
            $product_wishlist = ProductWishlist::where('product_id', $product->id)->where('user_id', Auth()->user()->id)->first();
            if ($product_wishlist != '') {
                $product->wishlistCheck = true;
            }
        }

        foreach (Cart::instance('cart')->content() as $cart) {
            if ($cart->id == $product->id) {
                $product->cartCheck = true;
            }
        }
        $product_rating = '';
        if (Auth::check()) {

            $product_rating = ProductRating::where('product_id', $product->id)->where('user_id', auth()->user()->id)->first();
        }
        if ($product_rating == '') {
            $product->product_rating = new ProductRating();
            $product->product_rating->rating = 0;
        } else {
            $product->product_rating = $product_rating;
        }

        $ratingData = $this->productRepository->getAvgProductRating($product->id);

        $productProgressBars = $this->productRepository->ratingProgressCalc($product->id);


        $return_data['categories'] = $this->categories;
        $return_data['category'] = $category;
        $return_data['sub_category'] = $sub_category;
        $return_data['product'] = $product;
        $return_data['all_ratings'] = $ratingData->all_ratings;
        $return_data['avg_rating'] = $ratingData->avg_rating;
        $return_data['productProgressBars'] = $productProgressBars;
        if(!empty($type)) {
            $return_data['type'] = $type;
        }
        return view('front.product-detail.product-detail', array_merge($data, $return_data));
    }

    public function addRating(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please Login after rating added to product']);
        }

        if ($request->rating == "0" || !$request->rating) {
            return response()->json(['success' => false, 'message' => 'Please select rating']);
        }

        $pro_id = $request->product_id;
        $user_id = Auth()->user()->id;
        $rating = $request->rating;

        $data['user_id'] = $user_id;
        $data['product_id'] = $pro_id;
        $data['rating'] = $rating;
        $data['status'] = 1;
        $rating = ProductRating::where('product_id', $pro_id)->where('user_id', $user_id)->first();

        if ($rating == '') {
            $product_rating = ProductRating::create($data);
            $msg = 'Rating added successfully!';
        } else {
            $product_rating = ProductRating::where('product_id', $pro_id)->where('user_id', $user_id)->update($data);
            $msg = 'Rating update successfully!';
        }

        $ratingData = $this->productRepository->getAvgProductRating($pro_id);
        $productProgressBars = $this->productRepository->ratingProgressCalc($pro_id);
        return response()->json([
            'success' => true, 'message' => $msg, 'progressBar' => $productProgressBars,
            'all_rating' =>$ratingData->all_ratings, 'avg_rating' => $ratingData->avg_rating
        ]);
    }
}
