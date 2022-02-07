<?php

namespace App\Repositories;

use App\Models\BlogCategory;

class BlogCategoryRepository
{
    public function __constuct()
    {
        //
    }

    public function create($data)
    {
        return BlogCategory::create($data);
    }

    public function update($id, $data)
    {
        $blog_category = BlogCategory::findOrFail($id);
        $blog_category->fill($data);
        $blog_category->save();
        return $blog_category;
    }

    public function delete($id)
    {
        $blog_category = BlogCategory::findOrFail($id);
        return BlogCategory::destroy($id);
    }

    public function blogCategories()
    {
        return BlogCategory::latest()->get();
    }
}
