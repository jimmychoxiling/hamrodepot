<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Repositories\BlogRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;

class BlogController extends Controller
{
    private $blogRepository;

    public function __construct(BlogRepository $blogRepository)
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.blog.index');
    }

    public function getBlog(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-info  btn-sm" href="' . route('blog-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('blog-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-href="' . route('blog-delete', $row->id) . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blog_category = BlogCategory::get();
        return view('Backend.blog.create',compact('blog_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogRequest $blogRequest)
    {
        $data = $blogRequest->validated();

        if($blogRequest->hasFile('image')) {
            $file = $blogRequest->file('image');
            $path = $file->store('blog');
            $data['image'] = $path;
        }
//        $data['slug'] = Str::slug($data['name'],'-');
        $blog = $this->blogRepository->create($data);

        return redirect()->route('blog')
            ->with('success', 'Blog Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog = Blog::find($id);

        return view('Backend.blog.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog_category = BlogCategory::get();
        $blog = Blog::find($id);

        return view('Backend.blog.edit', compact('blog','blog_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogRequest $blogRequest, $id)
    {
        $data = $blogRequest->validated();
//        $data['slug'] = Str::slug($data['name'],'-');

        if($blogRequest->hasFile('image')) {
            $file = $blogRequest->file('image');
            $path = $file->store('blog');
            $data['image'] = $path;
        }

        $blog = $this->blogRepository->update($id, $data);

        return redirect()->route('blog')
            ->with('success', 'Blog Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog = $this->blogRepository->delete($id);

        return redirect()->route('blog')
            ->with('success', 'Blog deleted successfully');
    }
}
