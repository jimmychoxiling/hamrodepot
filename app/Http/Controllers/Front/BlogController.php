<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use DB;
use function PHPUnit\Framework\isNull;

class BlogController extends Controller
{
    private $blogCategoryRepository;
    private $blogRepository;

    public function __construct(BlogCategoryRepository $blogCategoryRepository, BlogRepository $blogRepository)
    {
        parent::__construct();
        $this->blogCategoryRepository = $blogCategoryRepository;
        $this->blogRepository = $blogRepository;
    }

    public function blogs($slug2 = null,$slug3 = null,Request $request)
    {
        $data = array();

        $blogs = Blog::latest();


        if(!empty($slug2) && empty($slug3)){
            $blog_categories = BlogCategory::where('slug',$slug2)->first();
            if(!empty($blog_categories)){
                $blogs = $blogs->where('blog_category_id', $blog_categories->id);
            }

        }
        else if(!empty($slug2) && !empty($slug3)){
            $year = $slug2;
            $month = $slug3;

            $blogs = $blogs->whereYear('created_at', '=', $year)
                ->whereMonth('created_at', '=', $month);

        }elseif(isset($request->s) && $request->s != ''){
            $blogs = $blogs->Where('name', 'LIKE', '%'. $request->s . '%');
        }

        $blogs = $blogs->get();

        $blog_categories = $this->blogCategoryRepository->blogCategories();
        $recent_blogs = $this->blogRepository->recentBlog();
//        $archives_month_list =  Blog::select(DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
//            ->groupby('year','month')
//            ->get();
        $archives_month_list =  Blog::select(DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->get();


        $return_data['categories'] = $this->categories;
        $return_data['blogs'] = $blogs;
        $return_data['blog_categories'] = $blog_categories;
        $return_data['recent_blogs'] = $recent_blogs;
        $return_data['archives_month_list'] = $archives_month_list;

        return view('front.blogs.blogs', array_merge($data, $return_data));
    }

    public function blogDetail($slug2 = null,Request $request)
    {
        $data = array();

        $blog = Blog::where('slug',$slug2)->first();

        if(empty($blog)){
            abort(404);
        }

        $blog_categories = $this->blogCategoryRepository->blogCategories();
        $recent_blogs = $this->blogRepository->recentBlog();
        $archives_month_list =  Blog::select(DB::raw('YEAR(created_at) year, MONTH(created_at) month'))
            ->groupby('year','month')
            ->get();


        $return_data['categories'] = $this->categories;
        $return_data['blog'] = $blog;
        $return_data['blog_categories'] = $blog_categories;
        $return_data['recent_blogs'] = $recent_blogs;
        $return_data['archives_month_list'] = $archives_month_list;

        return view('front.blogs.blog-detail', array_merge($data, $return_data));
    }


}
