<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    private $productRepository;
    private $all_product_count;
    private $product_count;
    public function __construct(ProductsRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function search(Request $request)
    {
        $data = array();

        $products = array();
        if (isset($request->search) || isset($request->cat)) {
            $products = Products::where('status', '1');
            $search = $request->search;
            $cat = $request->cat;

            if ($search != '' && $search != 'all') {
                $products = $products->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', "%{$search}%");
                    $query->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            if ($cat != '') {
                $products = $products->with('categories')
                    ->whereHas('categories', function ($query) use ($cat) {
                        $query->where('category_id', $cat);
                    });
            }

            $max_amount =  $products->max('price');
            $max_amount = round($max_amount);
            $brands = array();

            if ($search == 'all') {
                $all_products = $products->get(); 
                foreach ($all_products as $products_val) {
                    $brands[] = $products_val->brand;
                }
                $this->all_product_count = count($all_products);
            }
            $products = $products->limit(env('PRODUCTS_LIMIT'))->get();


            foreach ($products as $products_val) {
                $products_val->wishlistCheck = $this->productRepository->hasProductInWhishlist($products_val);
                $category = $products_val->categories()->first();
                $sub_category = Category::where('parent_id', '=', $category->id)->first();

                $products_val->category = $category;
                $products_val->sub_category = $sub_category;
                if ($search != 'all') {
                    $brands[] = $products_val->brand;
                }
                $ratingData = $this->productRepository->getAvgProductRating($products_val->id);
                $products_val->avg_rating = $ratingData->avg_rating;
                $products_val->all_rating = $ratingData->all_ratings;
            }

            $brands = array_unique($brands);

            foreach ($brands as $brand) {
                $products_brand = Products::where('status', '1')->where('brands_id', $brand->id);
                $search = $request->search;
                $cat = $request->cat;

                if ($search != '' && $search != 'all') {
                    $products_brand = $products_brand->where(function ($query) use ($search) {
                        $query->orWhere('name', 'LIKE', "%{$search}%");
                        $query->orWhere('description', 'LIKE', "%{$search}%");
                    });
                }

                if ($cat != '') {
                    $products_brand = $products_brand->with('categories')
                        ->whereHas('categories', function ($query) use ($cat) {
                            $query->where('category_id', $cat);
                        });
                }

                $products_brand = $products_brand->get();
                $brand->products_count = count($products_brand);
            }

            $also_like_products = $this->productRepository->alsoLikeProduct();


            $return_data['categories'] = $this->categories;
            $return_data['products'] = $products;
            $return_data['all_products'] = $products;
            $return_data['max_amount'] = $max_amount;
            $return_data['brands'] = $brands;
            $return_data['also_like_products'] = $also_like_products;
            $return_data['all_product_count'] = $this->all_product_count;

            return view('front.product.product', array_merge($data, $return_data));
        } else {
            abort(404);
        }
    }

    public function filters(Request $request)
    {
        $view = $this->fetchProducts($request);
        return response()->json(['html' => $view, 'all_count' => $this->all_product_count, 'product_count' => $this->product_count]);
    }

    public function fetchProducts(Request $request)
    {
        if (isset($request->search) || isset($request->cat)) {
            $data = array();
            $products = Products::with('productsImagesFirst')->where('status', '1');
            $search = $request->search;
            $cat = $request->cat;

            if ($search != '' && $search != 'all') {
                $products = $products->where(function ($query) use ($search) {
                    $query->orWhere('name', 'LIKE', "%{$search}%");
                    $query->orWhere('description', 'LIKE', "%{$search}%");
                });
            }

            if ($cat != '') {
                $products = $products->with('categories')
                    ->whereHas('categories', function ($query) use ($cat) {
                        $query->where('category_id', $cat);
                    });
            }
            $all_products = $products->get();
            $this->all_product_count = count($all_products);
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

            $view = view('front.product.product-list', array_merge($data, $return_data))->render();
            return $view;
        }
    }
}
