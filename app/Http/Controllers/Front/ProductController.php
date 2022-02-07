<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductWishlist;
use App\Models\SubCategory;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private $productRepository;
    private $all_product_count;
    private $product_count;
    public function __construct(ProductsRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function index(Request $request, $slug2 = null, $slug3 = null, $slug4 = null)
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
        $SubCategoryId = $sub_category->id;

        $types = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('parent_id', $SubCategoryId)->get();
        $typeId = 0;
        $also_like_products = $this->productRepository->alsoLikeProduct();


        $category_filter =  Category::where('parent_id', '=', null)->where('level', '=', 1)->where('slug', $slug2)->get();
        foreach ($category_filter as $category_filter_val){
            $sub_category_filter = Category::where('parent_id', '!=', null)->where('level', '=', 2)->where('parent_id', $category_filter_val->id)->get();
            $category_filter_val->sub_category = $sub_category_filter;
            foreach ($sub_category_filter as $sub_category_filter_val){
                $types = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('parent_id', $sub_category_filter_val->id)->get();
                $sub_category_filter_val->types = $types;
            }
        }

        if (count($types) > 0 && $slug4 == null) {
            $return_data['categories'] = $this->categories;
            $return_data['category'] = $category;
            $return_data['sub_category'] = $sub_category;
            $return_data['also_like_products'] = $also_like_products;
            $return_data['types'] = $types;
            $return_data['category_filter'] = $category_filter;

            return view('front.category.type', array_merge($data, $return_data));
        } else {

            $products = Products::select('id', 'name', 'price', 'sell_type', 'slug', 'brands_id')->where('status', '1');
            $products = $products->with('categories')
                ->whereHas('categories', function ($query) use ($SubCategoryId) {
                    $query->where('category_id', $SubCategoryId);
                });
            if ($slug4 !== null) {
                $type = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('slug', $slug4)->first();
                if (empty($type)) {
                    $product = Products::where('status', '1')->where('slug', $slug4)->first();
                    if (!empty($product)) {
                        return redirect()->action(
                            [ProductDetailController::class, 'index'],
                            [
                                'slug2' => $category->slug,
                                'slug3' => $sub_category->slug,
                                'slug4' => $slug4,
                            ]
                        );
                    }
                } else {
                    $typeId = $type->id;
                    $products = $products->with('categories')
                        ->whereHas('categories', function ($query) use ($typeId) {
                            $query->where('category_id', $typeId);
                        });
                }
            }

            $max_amount =  $products->max('price');
            $max_amount = round($max_amount);
            $all_products = $products->get();

            $products = $products->limit(env('PRODUCTS_LIMIT'))->get();

            $brands = array();
            foreach ($all_products as $pro_all) {
                $brands[] = $pro_all->brand;
            }
            $brands = array_unique($brands);
            foreach ($brands as $brand) {
                $products_brand = Products::where('status', '1')->where('brands_id', $brand->id);
                $products_brand = $products_brand->with('categories')
                    ->whereHas('categories', function ($query) use ($SubCategoryId) {
                        $query->where('category_id', $SubCategoryId);
                    });
                if (!empty($type) && $typeId > 0) {
                    $products_brand =  $products_brand->with('categories')
                        ->whereHas('categories', function ($query) use ($typeId) {
                            $query->where('category_id', $typeId);
                        });
                }
                $products_brand = $products_brand->get();
                $brand->products_count = count($products_brand);
            }

            foreach ($products as $products_val) {
                $ratingData = $this->productRepository->getAvgProductRating($products_val->id);
                $products_val->avg_rating = $ratingData->avg_rating;
                $products_val->all_rating = $ratingData->all_ratings;
                $products_val->wishlistCheck = $this->productRepository->hasProductInWhishlist($products_val);
                $products_val->category = $category;
                $products_val->sub_category = $sub_category;
                if (!empty($type)) {
                    $products_val->type = $type;
                }
            }



            $return_data['categories'] = $this->categories;
            $return_data['category'] = $category;
            $return_data['sub_category'] = $sub_category;
            $return_data['products'] = $products;
            $return_data['all_products'] = $all_products;
            $return_data['brands'] = $brands;
            $return_data['max_amount'] = $max_amount;
            $return_data['also_like_products'] = $also_like_products;
            $return_data['category_filter'] = $category_filter;
            if (!empty($type)) {
                $return_data['type'] = $type;
            }

            return view('front.product.product', array_merge($data, $return_data));
        }
    }

    public function filters(Request $request)
    {
        $view = $this->fetchProducts($request);
        return response()->json(['html' => $view, 'all_count' => $this->all_product_count, 'product_count' => $this->product_count]);
    }

    public function fetchProducts(Request $request)
    {

        $data = array();
        $category = Category::where('parent_id', '=', null)->where('level', '=', 1)->where('slug', $request->slug2)->first();
        if (empty($category)) {
            abort(404);
        }

        $sub_category = Category::where('parent_id', '!=', null)->where('level', '=', 2)->where('slug', $request->slug3)->first();
        if (empty($sub_category)) {
            abort(404);
        }
        $SubCategoryId = $sub_category->id;

        $products = Products::select('id', 'name', 'price', 'sell_type', 'slug', 'brands_id')->where('status', '1');
//        $products = $products->with('categories')
//            ->whereHas('categories', function ($query) use ($SubCategoryId) {
//                $query->where('category_id', $SubCategoryId);
//            });
//        if ($request->slug4 !== "") {
//            $type = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('slug', $request->slug4)->first();
//            if (!empty($type)) {
//                $typeId = $type->id;
//                $products = $products->with('categories')
//                    ->whereHas('categories', function ($query) use ($typeId) {
//                        $query->where('category_id', $typeId);
//                    });
//            }
//        }
        $all_products = $products->get();
        $this->all_product_count = count($all_products);

        if(isset($request->category)){
            $category_filter = $request->category;

            $products->whereHas('categories',function($query) use($category_filter){
                $query->whereIn('category_id',$category_filter);
            });
        }
        if (isset($request->brand)) {
            $products = $products->whereIn('brands_id', $request->brand);
        }
        if (isset($request->min_price) && isset($request->max_price)) {
            $min_price = $request->min_price;
            $max_price = $request->max_price;
            $products = $products = $products->whereBetween('price', [$min_price, $max_price]);
        }
        if (isset($request->sell_type)) {
            if (!in_array('Both', $request->sell_type)) {
                $products = $products->whereIn('sell_type', $request->sell_type);
            }
        }
        if (isset($request->sort_by)) {
            $sort = $request->sort_by;
            if ($sort == 'price_ltoh') {
                $products =  $products->orderBy('price', 'asc');
            }
            if ($sort == 'price_htol') {
                $products =  $products->orderBy('price', 'desc');
            }
            if ($sort == 'a-z') {
                $products =  $products->orderBy('name', 'asc');
            }
            if ($sort == 'z-a') {
                $products =  $products->orderBy('name', 'desc');
            }
            if ($sort == 'recent-first') {
                $products =  $products->orderBy('created_at', 'asc');
            }
            if ($sort == 'recent-last') {
                $products =  $products->orderBy('created_at', 'desc');
            }
            if ($sort == 'top-rated') {
                $products = $products->with('productRatings')
                    ->whereHas('productRatings', function ($query) {
                        $query->orderBy('rating', 'desc');
                    });
            }
        }
        if (isset($request->rating)) {
            $min = min($request->rating);
            $max = max($request->rating);
            $max = $min + 1;
            $products = $products->with('productRatings')
                ->whereHas('productRatings', function ($query) use ($min, $max) {
                    $query->whereBetween('rating', [$min, $max]);
                });
        }

        $products = $products->skip($request->limit)->take(env('PRODUCTS_LIMIT'))->get();

        $this->product_count = count($products);
        foreach ($products as $products_val) {
            $ratingData = $this->productRepository->getAvgProductRating($products_val->id);
            $products_val->avg_rating = $ratingData->avg_rating;
            $products_val->all_rating = $ratingData->all_ratings;
            $products_val->wishlistCheck = $this->productRepository->hasProductInWhishlist($products_val);
            $products_val->category = $category;
            $products_val->sub_category = $sub_category;
        }
        $return_data['categories'] = $this->categories;
        $return_data['category'] = $category;
        $return_data['sub_category'] = $sub_category;
        $return_data['products'] = $products;
        $return_data['all_products'] = $all_products;

        $view = view('front.product.product-list', array_merge($data, $return_data))->render();
        return $view;
    }
}
