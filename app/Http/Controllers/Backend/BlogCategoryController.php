<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BlogCategoryRequest;
use App\Models\BlogCategory;
use App\Repositories\BlogCategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;

class BlogCategoryController extends Controller
{
    private $blogCategoryRepository;

    public function __construct(BlogCategoryRepository $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.blog-category.index');
    }

    public function getBlogCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = BlogCategory::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-info  btn-sm" href="' . route('blog-category-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('blog-category-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
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
        return view('Backend.blog-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlogCategoryRequest $blogCategoryRequest)
    {
        $data = $blogCategoryRequest->validated();

//        $data['slug'] = Str::slug($data['name'],'-');
        $blog_category = $this->blogCategoryRepository->create($data);

        return redirect()->route('blog-category')
            ->with('success', 'Blog Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog_category = BlogCategory::find($id);

        return view('Backend.blog-category.show', compact('blog_category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog_category = BlogCategory::find($id);

        return view('Backend.blog-category.edit', compact('blog_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlogCategoryRequest $blogCategoryRequest, $id)
    {
        $data = $blogCategoryRequest->validated();
//        $data['slug'] = Str::slug($data['name'],'-');

        $blog_category = $this->blogCategoryRepository->update($id, $data);

        return redirect()->route('blog-category')
            ->with('success', 'Blog Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blog_category = $this->blogCategoryRepository->delete($id);

        return redirect()->route('blog-category')
            ->with('success', 'BLog Category deleted successfully');
    }
}
