<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Repositories\ServiceCategoryRepository;
use App\Http\Requests\Backend\ServiceCategoryRequest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataTables;
use Auth, DB;

class ServiceCategoryController extends Controller
{
    private $ServiceCategoryRepository;
   
    public function __construct(ServiceCategoryRepository $serviceCategoryRepository)
    {
        $this->serviceCategoryRepository = $serviceCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.service-category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = null;
        $categories = ServiceCategory::orderBy('id','DESC')->get();
        return view('Backend.service-category.create',compact('categories','category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceCategoryRequest $serviceCategoryRequest)
    {
        $data = $serviceCategoryRequest->validated();
        if($serviceCategoryRequest->hasFile('image')) {
            $file = $serviceCategoryRequest->file('image');
            $name =  Str::slug($data['name'],'-').$file->getClientOriginalName();
            $file->storeAs('service-category', $name);
            $path = 'service-category/'.$name;	
            $data['image'] = $path;
        }
        $data['seller_id'] = auth()->user()->id;
        if (Auth::user()->hasRole('Admin')) {
            $data['status'] =  1;
        }

        if(!empty($data['id']) && $data['id'] > 0){
            $category = $this->serviceCategoryRepository->update($data['id'], $data);
            $message = "Category Updated Successfully!";
        } else {
            $category = $this->serviceCategoryRepository->create($data);
            $message = "Category Added Successfully!";
        }

        return redirect()->route('service.category')->with('success', $message);
        // return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('Backend.service-category.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = ServiceCategory::find(base64_decode($id));
        $categories = null;
        $categories = ServiceCategory::orderBy('id','DESC')->get();

        return view('Backend.service-category.create', compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /* DataTable on index page*/
    public function getServiceCategory(Request $request)
    {
        if ($request->ajax()) {
            $type = $request->type;

            $data = ServiceCategory::select('*');
            

            if(Auth::user()->hasRole('Seller')) {
                $data = $data->where('seller_id', auth()->user()->id);
            }

            $data = $data->latest()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $statusArr = array_flip(config('constant.STATUS'));
                    $status = $statusArr[$row->status];
                    $class = 'info';
                    if($row->status == 1){
                        $class = 'success';
                    } elseif($row->status == 2 || $row->status == 3){
                        $class = 'danger';
                    }

                    return '<div class="status-main"><span class="status badge badge-pill badge-'.$class.'">'.$status.'</span></div>';
                })
                ->addColumn('action', function ($row) use($type){
                    $checked = "";
                    if($row->status == 1){
                        $checked = "checked";
                    }
                    $blocked = 'none';
                    if($row->status != 0){
                        $blocked = 'block';
                    }

                    $none = 'none';
                    if($row->status == 0){
                        $none = 'block';
                    }

                    $innerDiv = "";
                    
                    $actionBtn = $innerDiv;

                    if($row->status != 3){
                        $innerDiv .= '<div class="after-active" style="display: '.$blocked.'">
                            <label class="custom-toggle">
                                <input type="checkbox" value="1" '.$checked.' class="category-status active-inactive" id="'.$row->id.'">
                                <span class="custom-toggle-slider rounded-circle"></span>
                            </label>
                        </div>';
                    }
                    
                    if((Auth::user()->hasRole('Admin')) || (Auth::user()->hasRole('Seller') && Auth::id() == $row->seller_id)){
                        $actionBtn = $innerDiv;
                    }
                    
                    if(Auth::user()->hasRole('Admin')){
                        if($row->status == 0){
                            $actionBtn .= '<div class="before-active mb-1" style="display: '.$none.'">
                                <a href="javascript:void(0)" class="btn btn-sm btn-success text-capitalize category-status approve-reject" data-status="'.config("constant.STATUS.Active").'" title="approve" id="'.$row->id.'">Approve</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger text-capitalize category-status approve-reject" data-status="'.config("constant.STATUS.Rejected").'" title="reject" id="'.$row->id.'">Reject</a>
                            </div>';   
                        }
                    }
                    
                    if((Auth::user()->hasRole('Admin')) || (Auth::user()->hasRole('Seller') && Auth::id() == $row->seller_id)){
                        $actionBtn .= '<a href="' . route('service.category.edit', ['id'=>base64_encode($row->id), 'type' => $type]) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
    /* status update on index page ajax call */
    public function changeStatus(Request $request){

        $category = ServiceCategory::findOrFail($request->id);
        $existing_status = $category->status;

        $category->status = $request->status;
        $execute = $category->save();

        $message = 'something went wrong, please try again';
        $statusArr = array_flip(config('constant.STATUS'));
        $status = $statusArr[$request->status];

        if($execute){
            if(isset($request->type) && $request->type == 'approve-reject'){
                $message = 'Status has been '.$status.' successfully';
            }
        }

        if($existing_status == 0 && $execute){
            $type = "Service Category";
            $text = $category->name;
            $color = "green";
            $status = "Approved";
            if($request->status == 3){
                $color = "red";
                $status = "Rejected";
            }

            $details['type'] = $type;
            $details['text'] = $text;
            $details['color'] = $color;
            $details['status'] = $status;
            $details['email'] = $category->seller->email;
            $details['name'] = $category->seller->name;
            $details['subject'] = "Approve/Reject Email";

            dispatch(new \App\Jobs\SendApproveRejectJob($details));
        }


        return json_encode(array('success' => $execute, 'message'=> $message, 'status' => $request->status, 'statusText' => $status, 'name' => $request->name));
    }
    
}
