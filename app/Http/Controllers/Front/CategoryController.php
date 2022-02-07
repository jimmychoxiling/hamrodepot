<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    private $productRepository;
    public function __construct(ProductsRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function index(Request $request, $slug2 = null)
    {
        $data =array();

        $category = Category::where('parent_id','=',null)->where('slug', $slug2)->first();

        if (empty($category)) {
            abort(404);
        }

        $sub_categories = Category::where('parent_id','!=',null)->where('parent_id',$category->id)->get();


        $also_like_products = $this->productRepository->alsoLikeProduct();

        $return_data['categories'] = $this->categories;
        $return_data['category'] = $category;
        $return_data['sub_categories'] = $sub_categories;
        $return_data['also_like_products'] = $also_like_products;

        return view('front.category.category', array_merge($data, $return_data));
    }
}
