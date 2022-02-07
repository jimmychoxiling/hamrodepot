<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\ServiceRequest;
use App\Models\ServiceCategory;
use App\Models\Service;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use DataTables;
use Auth, DB, Log;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
     private $ServiceRepository;

     private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $service = null;
        $serviceCategories = ServiceCategory::select('id','name')->where('status',1)->orderBy('name','asc')->get();
        return view('Backend.service.create', compact('service','serviceCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $serviceRequest)
    {
        DB::beginTransaction();
        try{
            $data = $serviceRequest->validated();
            
            if($serviceRequest->hasFile('image')) {
                $file = $serviceRequest->file('image');
                $name =  Str::slug($data['name'],'-').$file->getClientOriginalName();
                $file->storeAs('service', $name);
                $path = 'service/'.$name;	
                $data['image'] = $path;
            }
            
            $data['seller_id'] = auth()->user()->id;      
            $data['time']  = json_encode($serviceRequest->time);//implode(', ', $serviceRequest->time);
            if(!empty($data['id']) && $data['id'] > 0){
                $service = $this->serviceRepository->update($data['id'], $data);
                $message = "Service Updated Successfully!";
            } else {
                $service = $this->serviceRepository->create($data);
                $message = "Service Added Successfully!";
            }
            
            $service->addresses()->delete();
            if(!empty($serviceRequest->address)){
                foreach ($serviceRequest->address as $key => $address) {
                    $addressData = [
                        'address' => $address,
                        'country' => isset($serviceRequest->country[$key]) ? $serviceRequest->country[$key] : null,
                        'state' => isset($serviceRequest->state[$key]) ? $serviceRequest->state[$key] : null,
                        'city' => isset($serviceRequest->city[$key]) ? $serviceRequest->city[$key] : null,
                        'zipcode' => isset($serviceRequest->zipcode[$key]) ? $serviceRequest->zipcode[$key] : null,
                        'lat' => isset($serviceRequest->lat[$key]) ? $serviceRequest->lat[$key] : null,
                        'lng' => isset($serviceRequest->lng[$key]) ? $serviceRequest->lng[$key] : null,
                        'price' => isset($serviceRequest->price[$key]) ? $serviceRequest->price[$key] : null,
                    ];

                    $service->addresses()->create($addressData);
                }
            }

            DB::commit();
            return redirect()->route('services')->with('success', $message);
        } catch (Exception $e) {
            Log::info('add service catch exception:: Message:: '.$e->getMessage().' line:: '.$e->getLine().' Code:: '.$e->getCode().' file:: '.$e->getFile());
            $code = ($e->getCode() != '') ? $e->getCode():500;
            DB::rollback();
            return redirect()->route('service.create')->with('success', 'Something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $service = Service::where('slug',$slug)->first();

        return view('Backend.service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $service = Service::find(base64_decode($id));
        $serviceCategories = ServiceCategory::select('id','name')->where('status',1)->orderBy('name','asc')->get();
        return view('Backend.service.create', compact('service','serviceCategories'));
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
    public function getServices(Request $request)
    {
        if ($request->ajax()) {
            if(Auth::user()->hasRole('Admin')) {
                $data = $data = Service::latest()->get();
            } else {
                $data = Service::where('seller_id', auth()->user()->id)->latest()->get();
            }
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
                ->addColumn('seller_id', function ($row) {
                    return $row->seller->name ?? '-';
                })
                ->addColumn('service_category_id', function ($row) {
                    return $row->category->name ?? '-';
                })
                ->addColumn('action', function ($row) {
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
                                <input type="checkbox" value="1" '.$checked.' class="service-status active-inactive" id="'.$row->id.'">
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
                                <a href="javascript:void(0)" class="btn btn-sm btn-success text-capitalize service-status approve-reject" data-status="'.config("constant.STATUS.Active").'" title="approve" id="'.$row->id.'">Approve</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger text-capitalize service-status approve-reject" data-status="'.config("constant.STATUS.Rejected").'" title="reject" id="'.$row->id.'">Reject</a>
                            </div>';   
                        }
                    }
                    
                    if((Auth::user()->hasRole('Admin')) || (Auth::user()->hasRole('Seller') && Auth::id() == $row->seller_id)){
                        $actionBtn .= '<a class="btn btn-info  btn-sm" href="' . route('service.show', $row->slug) . '"><i class="fa fa-eye"></i></a>';
                    }
                    if(Auth::user()->hasRole('Seller')){
                        $actionBtn .= '<a href="' . route('service.edit', base64_encode($row->id)) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>';
                    }
                    return $actionBtn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
     /* status update on index page ajax call */
    public function changeStatus(Request $request){
        $service = Service::findOrFail($request->id);
        $existing_status = $service->status;

        $service->status = $request->status;
        $execute = $service->save();

        $message = 'something went wrong, please try again';
        $statusArr = array_flip(config('constant.STATUS'));
        $status = $statusArr[$request->status];

        if($execute === true){
            if(isset($request->type) && $request->type == 'approve-reject'){
                $message = 'Status has been '.$status.' successfully';
            }
        }

        if($existing_status == 0 && $execute){
            $type = "Service";
            $text = $service->name;
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
            $details['email'] = $service->seller->email;
            $details['name'] = $service->seller->name;
            $details['subject'] = "Approve/Reject Email";

            dispatch(new \App\Jobs\SendApproveRejectJob($details));
        }
        return json_encode(array('success' => $execute, 'message'=> $message, 'status' => $request->status, 'statusText' => $status, 'name' => $request->name));
    }
}
