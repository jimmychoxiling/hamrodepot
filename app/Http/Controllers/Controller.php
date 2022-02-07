<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $categories  = Category::where('parent_id', '=', null)->get();

        foreach ($categories as $category) {
            $category->sub_category = Category::where('parent_id', $category->id)->where('parent_id', '!=', null)->where('level', 2)->get();
            if (count($category->sub_category) > 0) {
                foreach ($category->sub_category as $key => $sub_category) {
                    $sub_category->level = Category::where('parent_id', $sub_category->id)->where('parent_id', '!=', null)->where('level', 3)->get();
                }
            }
        }

        $this->categories  = $categories;
    }
}
