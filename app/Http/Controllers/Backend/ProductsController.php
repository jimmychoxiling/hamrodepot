<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ProductsRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Products;
use App\Models\User;
use App\Repositories\ProductsImagesRepository;
use App\Repositories\ProductsRepository;
use Illuminate\Http\Request;
use DataTables;
use Auth;
use Illuminate\Support\Str;

class ProductsController extends Controller
{
    private $productsRepository;
    private $productsImagesRepository;

    public function __construct(ProductsRepository $productsRepository, ProductsImagesRepository $productsImagesRepository)
    {
        $this->productsRepository = $productsRepository;
        $this->productsImagesRepository = $productsImagesRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.products.index');
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = Products::latest()->get();
            } else {
                $data = Products::where('seller_id', auth()->user()->id)->latest()->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('seller', function ($row) {

                    $seller = $row->user->name . ' ' . $row->user->last_name;

                    return $seller;
                })
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
                            return '<div class="status-main"><span class="product-badge badge badge-pill badge-' . $class . '">Active</span></div>';
                        case '2':
                            return '<div class="status-main"><span class="product-badge badge badge-pill badge-' . $class . '">InActive</span></div>';
                        case '3':
                            return '<div class="status-main"><span class="product-badge badge badge-pill badge-' . $class . '">Reject</span></div>';
                        default:
                            return '<div class="status-main"><span class="product-badge badge badge-pill badge-' . $class . '">Pending</span></div>';
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
                        <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateProduct product-status active-inactive" data-id="' . $row->id . '" >
                        <span class="custom-toggle-slider rounded-circle"></span>
                        </label>
                        <div class="row mb-1">
                        <a href="javascript:void(0);" data-id="' .  $row->id . '" data-status="' .  $row->status . '" class="btn btn-success btn-sm approve-status statusUpdateProduct" style="display: ' . $approvebtndisplay . '"><i class="fa fa-check-circle"></i> Approved</a>
                        <a href="javascript:void(0);"  data-id="' .  $row->id . '" data-status="' .  $row->status . '" class="btn btn-danger btn-sm reject-status statusUpdateProduct" style="display: ' . $rejectbtndisplay . '"><i class="fa fa-ban"></i> Reject</a>
                        </div>';
                    }
                    $actionBtn = '<a class="btn btn-info  btn-sm" href="' . route('products-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('products-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-href="' . route('products-delete', $row->id) . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $statusBtn . $actionBtn;
                })
                ->rawColumns(['status', 'seller', 'action'])
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
        $category = Category::where('parent_id', '=', null)->where('status', '=', 1)->where('level', '=', 1)->get();
        $brand = Brand::where('status', '1')->get();
        $seller = User::where('status', '1')->whereHas('roles', function ($q) {
            return $q->where('name', 'Seller');
        })->get();

        return view('Backend.products.create', compact('category', 'brand', 'seller'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductsRequest $productsRequest)
    {
        $data = $productsRequest->validated();

        if (Auth::user()->hasRole('Seller')) {
            $data['status'] =  0;
            $data['seller_id'] = auth()->user()->id;
        } else {
            $data['status'] =  1;
        }
        if($productsRequest->show_home_feature && $productsRequest->show_home_feature == 'on') {
            $data['show_home_feature'] = 1;
            if (!$this->productsRepository->checkHomePageFeatures(null)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Do not add more then 8 features products! Please uncheck other products');
            }
        } else {
            $data['show_home_feature'] = 0;
        }

        $products = $this->productsRepository->create($data);
        $products->categories()->sync($productsRequest->category_id, false);
        $products->categories()->sync($productsRequest->subcategory_id, false);
        $products->categories()->sync($productsRequest->type_id, false);


        $data_products_images['product_id'] = $products->id;

        if ($productsRequest->hasfile('filename')) {
            foreach ($productsRequest->file('filename') as $file) {
                $path = $file->store('products');
                $data_products_images['filename'] = $path;
                $products_images = $this->productsImagesRepository->create($data_products_images);
            }
        }
        return redirect()->route('products')
            ->with('success', 'Products Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Products::find($id);


        return view('Backend.products.show', compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::where('parent_id', '=', null)->where('status', '=', 1)->where('level', '=', 1)->get();
        $brand = Brand::where('status', '1')->get();
        $seller = User::where('status', '1')->whereHas('roles', function ($q) {
            return $q->where('name', 'Seller');
        })->get();

        $products = Products::with('productsImages')->find($id);
        $productsCategory = $products->categories->pluck('id', 'id')->all();

        $sub_category = Category::where('parent_id', '!=', null)->where('level', '=', 2)->where('status', '=', 1)->whereIn('parent_id', $productsCategory);
        $productsSubCategory = $sub_category->pluck('id', 'id')->all();
        $sub_category = $sub_category->get();
        $types = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('status', '=', 1)->whereIn('parent_id', $productsSubCategory)->get();

        return view('Backend.products.edit', compact('products', 'category', 'types', 'brand', 'productsCategory', 'sub_category', 'seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required',

        ]);

        $data = $request->all();

        if($request->show_home_feature && $request->show_home_feature == 'on') {
            $data['show_home_feature'] = 1;
            if (!$this->productsRepository->checkHomePageFeatures($id)) {
                return redirect()->back()->withInput()
                    ->with('error', 'Do not add more then 8 features products! Please uncheck other products');
            }
        } else {
            $data['show_home_feature'] = 0;
        }

        $products = $this->productsRepository->update($id, $data);
        $products->categories()->sync($request->category_id);
        $products->categories()->sync($request->subcategory_id, false);
        $products->categories()->sync($request->type_id, false);

        $data_products_images['product_id'] = $id;
        if ($request->hasfile('filename')) {
            foreach ($request->file('filename') as $file) {
                $path = $file->store('products');
                $data_products_images['filename'] = $path;
                $products_images = $this->productsImagesRepository->create($data_products_images);
            }
        }


        return redirect()->route('products')
            ->with('success', 'Products Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = $this->productsRepository->delete($id);

        return redirect()->route('products')
            ->with('success', 'Products deleted successfully');
    }

    public function removeProductsImages(Request $request)
    {
        $products_images = $this->productsImagesRepository->delete($request->id);

        return response()->json(['status' => true, 'message' => 'Image removed successfully'], 200);
    }

    public function getSubCategory(Request $request)
    {
        $html = '';
        if (isset($request->category_id)) {
            $sub_category = Category::where('parent_id', '!=', null)->where('level', '=', 2)->where('status', '=', 1)->whereIn('parent_id', $request->category_id)->get();

            if (count($sub_category) > 0) {

                foreach ($sub_category as $sub_category_val) {
                    $html .= '<option value="' . $sub_category_val->id . '">';
                    $sub_category_name = $sub_category_val->name;
                    $html .= $sub_category_name . '</option>';
                }
            } else {
                $html .= '<option value="">Choose Sub Category</option>';
            }
        } else {
            $html .= '<option value="">Choose Sub Category</option>';
        }


        return response()->json(['html' => $html]);
    }

    public function getTypes(Request $request)
    {
        $html = '';
        if (isset($request->sub_category_id)) {
            $types = Category::where('parent_id', '!=', null)->where('level', '=', 3)->where('status', '=', 1)->whereIn('parent_id', $request->sub_category_id)->get();

            if (count($types) > 0) {
                $html .= '<label class="form-control-label" for="input-type_id">Type</label>
                <select name="type_id[]" id="type_id" class="form-control form-control-alternative select2" required multiple="multiple" data-parsley-required-message="Type is required">';
                foreach ($types as $type_val) {
                    $html .= '<option value="' . $type_val->id . '">';
                    $type_name = $type_val->name;
                    $html .= $type_name . '</option>';
                }
                $html .='</select>';
            } else {
                $html .= '<label class="form-control-label" for="input-type_id">Type</label>
                <select name="type_id[]" id="type_id" class="form-control form-control-alternative select2" multiple="multiple">';
                $html .= '<option value="">Choose Type</option></select>';
            }
        } else {
            $html .= '<label class="form-control-label" for="input-type_id">Type</label>
            <select name="type_id[]" id="type_id" class="form-control form-control-alternative select2" multiple="multiple">';
            $html .= '<option value="">Choose Type</option></select>';
        }


        return response()->json(['html' => $html]);
    }

    public function updateStatus(Request $request)
    {
        $product = Products::find($request->id);
        $product['status'] = $request->status;
        $msg = "Product status successfully updated";

        $product = Products::find($request->id)->update($product->toArray());
        $product = Products::find($request->id);
        return response()->json(['success' => true, 'message' => $msg, 'status' => $product['status']]);
    }
}
