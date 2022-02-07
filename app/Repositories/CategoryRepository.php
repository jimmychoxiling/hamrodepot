<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CategoryRepository
{
    public function create($data)
    {
        return Category::create($data);
    }

    public function update($id, $data)
    {
        $category = Category::findOrFail($id);
        if(isset($data['image'])){
            Storage::delete($category->image);
        }
        $category->fill($data);
        $category->save();
        return $category;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        return Category::destroy($id);
    }

    public function checkHomePageTopCategory($id)
    {
        if($id !== null) {
            $category =  Category::where('parent_id', '=', null)->where('id', '=', $id)->first();
            if($category->show_home_top_category == 1) {
                return true;
            }
        }
        $categories =  Category::where('parent_id', '=', null)->where('level', '=', 1)->where('show_home_top_category', '=', 1)->get();
        if (count($categories) >= 10) {
            return false;
        } else {
            return true;
        }
    }
    public function checkHomePageCategory($id)
    {
        if($id !== null) {
            $category =  Category::where('parent_id', '=', null)->where('id', '=', $id)->first();
            if($category->show_home_page == 1) {
                return true;
            }
        }
        $categories =  Category::where('parent_id', '=', null)->where('level', '=', 1)->where('show_home_page', '=', 1)->get();
        if (count($categories) >= 4) {
            return false;
        } else {
            return true;
        }
    }
}
