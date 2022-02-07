<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    private $productRepository;

    public function __construct(ProductsRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function brands()
    {

        $data = array();

        $brands = Brand::where('status', '1')->get();

        $return_data['categories'] = $this->categories;
        $return_data['brands'] = $brands;

        return view('front.brands.brands', array_merge($data, $return_data));
    }

    public function brandsProducts(Request $request, $slug2 = null)
    {
        $data = array();

        $brand = Brand::where('status', '1')->where('slug', $slug2)->first();
        if (empty($brand)) {
            abort(404);
        }
        $products = Products::where('status', '1')->where('brands_id', $brand->id);

        $all_products = $products->get();
        $max_amount = $products->max('price');
        $max_amount = round($max_amount);

        $products = $products->limit(env('PRODUCTS_LIMIT'))->get();


        foreach ($products as $products_val) {
            $products_val->wishlistCheck = $this->productRepository->hasProductInWhishlist($products_val);
            $category = $products_val->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();

            $products_val->category = $category;
            $products_val->sub_category = $sub_category;
            $ratingData = $this->productRepository->getAvgProductRating($products_val->id);
            $products_val->avg_rating = $ratingData->avg_rating;
            $products_val->all_rating = $ratingData->all_ratings;
        }

        $category_filter = Category::where('parent_id', '=', null)->where('level', '=', 1)->get();
        foreach ($category_filter as $category_filter_val) {
            $sub_category_filter = Category::where('parent_id', '!=', null)->where('level', '=', 2)->where('parent_id', $category_filter_val->id)->get();
            $category_filter_val->sub_category = $sub_category_filter;
            foreach ($sub_category_filter as $sub_category_filter_val) {
                $types = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('parent_id', $sub_category_filter_val->id)->get();
                $sub_category_filter_val->types = $types;
            }
        }

        $return_data['categories'] = $this->categories;
        $return_data['products'] = $products;
        $return_data['all_products'] = $all_products;
        $return_data['max_amount'] = $max_amount;
        $return_data['brand'] = $brand;
        $return_data['category_filter'] = $category_filter;


        return view('front.product.product', array_merge($data, $return_data));
    }

    public function filters(Request $request)
    {
        $view = $this->fetchProducts($request);
        return response()->json(['html' => $view, 'all_count' => $this->all_product_count, 'product_count' => $this->product_count]);
    }

    public function fetchProducts(Request $request)
    {
        $data = array();
        $brand = Brand::where('status', '1')->where('id', $request->brandId)->first();
        if (empty($brand)) {
            abort(404);
        }
        $products = Products::with('productsImagesFirst')->where('status', '1')->where('brands_id', $brand->id);

        $all_products = $products->get();
        $this->all_product_count = count($all_products);

        if (isset($request->category)) {
            $category_filter = $request->category;

            $products->whereHas('categories', function ($query) use ($category_filter) {
                $query->whereIn('category_id', $category_filter);
            });
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
                $products = $products->orderBy('price', 'asc');
            }
            if ($sort == 'price_htol') {
                $products = $products->orderBy('price', 'desc');
            }
            if ($sort == 'a-z') {
                $products = $products->orderBy('name', 'asc');
            }
            if ($sort == 'z-a') {
                $products = $products->orderBy('name', 'desc');
            }
            if ($sort == 'recent-first') {
                $products = $products->orderBy('created_at', 'asc');
            }
            if ($sort == 'recent-last') {
                $products = $products->orderBy('created_at', 'desc');
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
            $products_val->wishlistCheck = $this->productRepository->hasProductInWhishlist($products_val);
            $category = $products_val->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();
            $products_val->category = $category;
            $products_val->sub_category = $sub_category;
            $brands[] = $products_val->brand;
            $ratingData = $this->productRepository->getAvgProductRating($products_val->id);
            $products_val->avg_rating = $ratingData->avg_rating;
            $products_val->all_rating = $ratingData->all_ratings;
        }
        $return_data['categories'] = $this->categories;
        $return_data['products'] = $products;
        $return_data['all_products'] = $all_products;
        $return_data['brand'] = $brand;

        $view = view('front.product.product-list', array_merge($data, $return_data))->render();
        return $view;
    }
}
