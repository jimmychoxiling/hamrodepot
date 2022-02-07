<?php

namespace App\Repositories;

use App\Models\Blog;
use Illuminate\Support\Facades\Storage;

class BlogRepository
{
    public function __constuct()
    {
        //
    }

    public function create($data)
    {
        return Blog::create($data);
    }

    public function update($id, $data)
    {
        $blog = Blog::findOrFail($id);
        if(isset($data['image'])){
            Storage::delete($blog->image);
        }
        $blog->fill($data);
        $blog->save();
        return $blog;
    }

    public function delete($id)
    {
        $blog = Blog::findOrFail($id);
        return Blog::destroy($id);
    }

    public function recentBlog()
    {
        return Blog::latest()->limit(5)->get();
    }
}
