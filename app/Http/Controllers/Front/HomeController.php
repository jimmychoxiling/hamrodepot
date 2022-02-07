<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;

use App\Models\Blog;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Products;
use File;
use Response;
use Illuminate\Http\Request;
use App\Models\OrderDetail;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = array();

        $home_categories1 = Category::where('parent_id',null)->where('show_home_page',1)->limit(4)->get();
        $home_categories = Category::where('parent_id',null)->where('show_home_top_category',1)->limit(10)->get();
        $home_brands = Brand::where('status','1')->limit(10)->get();
        $home_products = Products::select('id','name','price','slug', 'sell_type')->where('show_home_feature', 1)->where('status', '1')->orderBy('id','DESC')->limit(8)->get();
        
        $topProducts = OrderDetail::select(DB::raw('sum(total) as `totalcount`', 'product_id'), DB::raw('product_id'))->groupBy('product_id')->orderBy('totalcount', 'DESC')->limit(10)->get();
        
        foreach ($topProducts as $topProduct)
        {
            if($topProduct->product){
            $category = $topProduct->product->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->where('level', 2)->first();
            $level = Category::where('parent_id', '=', $sub_category->id)->where('level', 3)->first();
            $topProduct->category = $category;
            $topProduct->sub_category = $sub_category;
            $topProduct->level = $level;
            }
        }
        
        foreach ($home_products as $home_product)
        {
            $category = $home_product->categories()->first();
            $sub_category = Category::where('parent_id', '=', $category->id)->where('level', 2)->first();
            $level = Category::where('parent_id', '=', $sub_category->id)->where('level', 3)->first();
            $home_product->category = $category;
            $home_product->sub_category = $sub_category;
            $home_product->level = $level;
        }
        
        $hom_blogs = Blog::select('id','name','image','slug')->latest()->limit(4)->get();

        $return_data['categories'] = $this->categories;
        $return_data['home_categories1'] = $home_categories1;
        $return_data['home_categories'] = $home_categories;
        $return_data['home_brands'] = $home_brands;
        $return_data['home_products'] = $home_products;
        $return_data['hom_blogs'] = $hom_blogs;
        $return_data['topProducts'] = $topProducts;


        return view('front.index', array_merge($data, $return_data));
    }

    public function getFile($filename)
    {

        $path = storage_path('app/' . $filename);

        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    public function accountNotActive()
    {
        $data = array();
        $return_data['categories'] = $this->categories;

        return view('front.extra-pages.account-not-active', array_merge($data, $return_data));
    }

}
