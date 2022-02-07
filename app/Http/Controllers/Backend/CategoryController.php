<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.category.index');
    }

    public function getCategory(Request $request)
    {
        if ($request->ajax()) {
            $data = Category::where('parent_id', '=', null)->where('level', '=', 1)->latest()->get();
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
                            <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateCategory brand-status active-inactive" data-id="' . $row->id . '" >
                            <span class="custom-toggle-slider rounded-circle"></span>
                            </label>

                    <a class="btn btn-info  btn-sm" href="' . route('category-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('category-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
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
        return view('Backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $categoryRequest)
    {
        $data = $categoryRequest->validated();
        if ($categoryRequest->show_home_top_category && $categoryRequest->show_home_top_category == 'on') {
            $data['show_home_top_category'] = 1;
            if (!$this->categoryRepository->checkHomePageTopCategory(null)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Do not add more then 10 top category! Please uncheck others');
            }
        } else {
            $data['show_home_top_category'] = 0;
        }
        if ($categoryRequest->show_home_page && $categoryRequest->show_home_page == 'on') {
            $data['show_home_page'] = 1;
            if (!$this->categoryRepository->checkHomePageCategory(null)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Do not add more then 4 home category! Please uncheck others');
            }
        } else {
            $data['show_home_page'] = 0;
        }
        if ($categoryRequest->hasFile('image')) {
            $file = $categoryRequest->file('image');
            $path = $file->store('category');
            $data['image'] = $path;
        }
        $data['level'] = 1;
        //        $data['slug'] = Str::slug($data['name'],'-');
        $category = $this->categoryRepository->create($data);

        return redirect()->route('category')
            ->with('success', 'Category Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);

        return view('Backend.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::find($id);

        return view('Backend.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $categoryRequest, $id)
    {
        $data = $categoryRequest->validated();
        //        $data['slug'] = Str::slug($data['name'],'-');
        if ($categoryRequest->show_home_top_category && $categoryRequest->show_home_top_category == 'on') {
            $data['show_home_top_category'] = 1;
            if (!$this->categoryRepository->checkHomePageTopCategory($id)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Do not add more then 10 top category! Please uncheck other categories');
            }
        } else {
            $data['show_home_top_category'] = 0;
        }
        if ($categoryRequest->show_home_page && $categoryRequest->show_home_page == 'on') {
            $data['show_home_page'] = 1;
            if (!$this->categoryRepository->checkHomePageCategory($id)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Do not add more then 4 home category! Please uncheck other categories');
            }
        } else {
            $data['show_home_page'] = 0;
        }
        if ($categoryRequest->hasFile('image')) {
            $file = $categoryRequest->file('image');
            $path = $file->store('category');
            $data['image'] = $path;
        }

        $category = $this->categoryRepository->update($id, $data);

        return redirect()->route('category')
            ->with('success', 'Category Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = $this->categoryRepository->delete($id);

        return redirect()->route('category')
            ->with('success', 'Category deleted successfully');
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
