<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\BrandRequest;
use App\Models\Brand;
use App\Repositories\BrandRepository;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;

class BrandController extends Controller
{
    //
    private $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }
    public function index()
    {
        return view('Backend.brand.index');
    }
    public function getBrand(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = $data = Brand::latest()->get();
            } else {
                $data = Brand::where('seller_id', auth()->user()->id)->latest()->get();
            }

            return DataTables::of($data)
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
                    $statusBtn = "";
                    if (Auth::user()->hasRole('Admin')) {
                        $checked = "";
                        $display = "none";
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
                        $statusBtn = '<label class="custom-toggle" style="display: ' . $display . '">
                            <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateBrand brand-status active-inactive" data-id="' . $row->id . '" >
                            <span class="custom-toggle-slider rounded-circle"></span>
                            </label>
                            <div class="row mb-1">
                            <a href="javascript:void(0);" data-id="' .  $row->id . '" data-status="' .  $row->status . '" class="btn btn-success btn-sm approve-status statusUpdateBrand" style="display: ' . $approvebtndisplay . '"><i class="fa fa-check-circle"></i> Approved</a>
                            <a href="javascript:void(0);"  data-id="' .  $row->id . '" data-status="' .  $row->status . '" class="btn btn-danger btn-sm reject-status statusUpdateBrand" style="display: ' . $rejectbtndisplay . '"><i class="fa fa-ban"></i> Reject</a>
                            </div>';
                    }
                    $actionBtn = '<a class="btn btn-info  btn-sm" href="' . route('brand-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('brand-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-href="' . route('brand-delete', $row->id) . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $statusBtn . $actionBtn;
                })
                ->rawColumns(['status', 'action'])
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
        return view('Backend.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $brandRequest)
    {
        $data = $brandRequest->validated();
        $data['seller_id'] = auth()->user()->id;
        if ($brandRequest->hasFile('image')) {
            $file = $brandRequest->file('image');
            $path = $file->store('brand');
            $data['image'] = $path;
        }
        if (Auth::user()->hasRole('Seller')) {
            $data['status'] =  0;
        } else {
            $data['status'] =  1;
        }
        //        $data['slug'] = Str::slug($data['name'], '-');

        $brand = $this->brandRepository->create($data);

        return redirect()->route('brand')
            ->with('success', 'Brand Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $brand = Brand::find($id);

        return view('Backend.brand.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brand = Brand::find($id);
        return view('Backend.brand.edit', ['brand' => $brand]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $brandRequest, $id)
    {
        $data = $brandRequest->validated();

        $data['seller_id'] = auth()->user()->id;
        $data['slug'] = Str::slug($data['name'], '-');

        if ($brandRequest->hasFile('image')) {
            $file = $brandRequest->file('image');
            $path = $file->store('brand');
            $data['image'] = $path;
        }

        $category = $this->brandRepository->update($id, $data);

        return redirect()->route('brand')
            ->with('success', 'Brand Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $subCategory = $this->brandRepository->delete($id);

        return redirect()->route('brand')
            ->with('success', 'Brand deleted successfully');
    }

    public function updateStatus(Request $request)
    {
        $brand = Brand::find($request->id);
        $brand['status'] = $request->status;
        $msg = "Brand status successfully updated";

        $brand = Brand::find($request->id)->update($brand->toArray());
        $brand = Brand::find($request->id);
        return response()->json(['success' => true, 'message' => $msg, 'status' => $brand['status']]);
    }
}
