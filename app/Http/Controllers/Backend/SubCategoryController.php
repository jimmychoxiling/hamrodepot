<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SubCategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    //
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index()
    {
        return view('Backend.sub-category.index');
    }
    public function getSubCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('parent_id','!=',null)->where('level', '=', 2)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $class = 'danger';
                    if ($row->status == 1) {
                        $class = 'success';
                    }
                    if ($row->status == 0) {
                        $class = 'warning';
                    }

                    switch ($row->status) {
                        case '1':
                            return '<div class="status-main"><span class="status-badge badge badge-pill badge-' . $class . '">Active</span></div>';
                        case '2':
                            return '<div class="status-main"><span class="status-badge badge badge-pill badge-' . $class . '">InActive</span></div>';
                        case '3':
                            return '<div class="status-main"><span class="status-badge badge badge-pill badge-' . $class . '">Reject</span></div>';
                        default:
                            return '<div class="status-main"><span class="status-badge badge badge-pill badge-' . $class . '">Pending</span></div>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $checked = "";
                    $display = "block";
                    $approvebtndisplay = "none";
                    $rejectbtndisplay = "none";
                    if ($row->status == 1 || $row->status == 2) {

                        if ($row->status == 1) {
                            $checked = "checked";
                        }
                        $display = "block";
                    } elseif ($row->status == 3) {
                        $approvebtndisplay = "block";
                    } else {
                        $rejectbtndisplay = "block";
                        $approvebtndisplay = "block";
                    }
                    $actionBtn = '
                    <label class="custom-toggle" style="display: ' . $display . '">
                            <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateSubCategory brand-status active-inactive" data-id="' . $row->id . '" >
                            <span class="custom-toggle-slider rounded-circle"></span>
                            </label>

                    <a class="btn btn-info  btn-sm" href="' . route('sub-category-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('sub-category-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          ';
                    return $actionBtn;
                })
                ->rawColumns(['status','action'])
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
        $categories = Category::where('parent_id','=',null)->where('level', '=', 1)->get();
        return view('Backend.sub-category.create', ['categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubCategoryRequest $subCategoryRequest)
    {
        $data = $subCategoryRequest->validated();

        $data['parent_id'] = $subCategoryRequest->category_id;
        if ($subCategoryRequest->hasFile('image')) {
            $file = $subCategoryRequest->file('image');
            $path = $file->store('category');
            $data['image'] = $path;
        }
        $data['level'] = 2;
//        $data['slug'] = Str::slug($data['name'], '-');
        $subCategory = $this->categoryRepository->create($data);

        return redirect()->route('sub-category')
            ->with('success', 'Sub-Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subCategory = Category::find($id);

        return view('Backend.sub-category.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subCategory = Category::find($id);
        $categories = Category::where('parent_id','=',null)->where('level', '=', 1)->get();

        return view('Backend.sub-category.edit', ['subCategory' => $subCategory, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubCategoryRequest $subCategoryRequest, $id)
    {
        $data = $subCategoryRequest->validated();
//        $data['slug'] = Str::slug($data['name'], '-');
        $data['parent_id'] = $subCategoryRequest->category_id;


        if ($subCategoryRequest->hasFile('image')) {
            $file = $subCategoryRequest->file('image');
            $path = $file->store('category');
            $data['image'] = $path;
        }

        $category = $this->categoryRepository->update($id, $data);

        return redirect()->route('sub-category')
            ->with('success', 'Sub-Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subCategory = $this->categoryRepository->delete($id);

        return redirect()->route('sub-category')
            ->with('success', 'Sub-Category deleted successfully');
    }
    public function updateStatus(Request $request)
    {
        $category = Category::find($request->id);
        $category['status'] = $request->status;
        $msg = "Category status successfully updated";

        $category = Category::find($request->id)->update($category->toArray());
        $category = Category::find($request->id);
       
        return response()->json(['success' => true, 'message' => $msg, 'status' => $category['status']]);
    }
}
