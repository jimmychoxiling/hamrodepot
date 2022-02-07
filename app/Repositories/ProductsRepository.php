<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\ProductRating;
use App\Models\Products;
use App\Models\ProductsImages;
use App\Models\ProductWishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductsRepository
{
    public function create($data)
    {
        return Products::create($data);
    }

    public function update($id, $data)
    {
        $products = Products::findOrFail($id);
        $products->fill($data);
        $products->save();
        return $products;
    }

    public function delete($id)
    {
        $products = Products::findOrFail($id);
        $product_wishlist = ProductWishlist::where('product_id', $id)->delete();
        return Products::destroy($id);
    }
    public function hasProductInWhishlist(Products $product)
    {
        if (Auth::check()) {
            $product_wishlist = ProductWishlist::where('product_id', $product->id)->where('user_id', Auth()->user()->id)->first();
            if ($product_wishlist != '') {
                return  true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function alsoLikeProduct()
    {
        $also_like_products = Products::select('id','name','slug','price', 'sell_type')->where('status', '1')->orderBy('id', 'DESC')->limit(10)->get();

        foreach ($also_like_products as $also_like_product) {
            $category = $also_like_product->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->first();

            $also_like_product->category = $category;
            $also_like_product->sub_category = $sub_category;
        }

        return $also_like_products;
    }
    public function ratingProgressCalc($product_id)
    {
        $products = ProductRating::where('product_id', $product_id);

        $data = array();
        for ($i = 0; $i < 5; $i++) {
            $pro = array();
            $min = $i;
            $max = $min + 1;
            $pro['products'] = ProductRating::where('product_id', $product_id)->where('status', 1)->whereBetween('rating', [$min, $max])->get();
            $pro['all_ratings'] = count($pro['products']);
            if (count($pro['products']) > 0 && count($products->get()) > 0) {
                $pro['percentage'] = (count($pro['products']) / count($products->get()) * 100);
            } else {
                $pro['percentage'] = 0;
            }
            array_push($data, $pro);
        }
        return $data;
    }
    public function getAvgProductRating($product_id)
    {
        $data = collect();
        $all_ratings_products = ProductRating::where('product_id', $product_id);
        $all_ratings = count($all_ratings_products->get());
        $avg_rating = 0;
        if ($all_ratings > 0) {
            $avg_rating =  $all_ratings_products->sum('rating') / $all_ratings;
            $avg_rating = number_format($avg_rating, 1);
        }
        $data->avg_rating = $avg_rating;
        $data->all_ratings = $all_ratings;
        return $data;
    }

    public function checkHomePageFeatures($id)
    {
        if($id !== null) {
            $product =  Products::where('id', '=', $id)->first();
            if($product->show_home_feature == 1) {
                return true;
            }
        }
        $products =  Products::where('status', '=', 1)->where('show_home_feature', '=', 1)->get();
        if (count($products) >= 8) {
            return false;
        } else {
            return true;
        }
    }
}
