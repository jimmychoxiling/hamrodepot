<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceCategory;
use App\Models\Service;
use Auth;
use App\Models\ServiceRequest;

class ServiceController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function service()
    {
        $data = array();
        $serviceCategories = ServiceCategory::where('status',1)->limit(8)->orderBy('updated_at','DESC')->get();
        $return_data['categories'] = $this->categories;
        $max_amount = Service::max('price');
        $max_amount = round($max_amount);
        return view('front.services.service', array_merge($data, $return_data),compact('serviceCategories','max_amount'));
    }

    public function serviceDetails($slug)
    {
        $data = array();
        $serviceCategories = ServiceCategory::where('status',1)->limit(8)->orderBy('updated_at','DESC')->get();
        $services = ServiceCategory::with('service')->where('status',1)->where('slug',$slug)->first();
        $max_amount =  $services->service->max('price');
        $max_amount = round($max_amount);
        $services_count = $services->service->count();
        $return_data['categories'] = $this->categories;
        return view('front.services.service-details', array_merge($data, $return_data),compact('serviceCategories','services','max_amount','slug','services_count'));
    }
    public function service3()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.services.service3', array_merge($data, $return_data));
    }
    public function service4()
    {
        $data = array();

        $return_data['categories'] = $this->categories;
        return view('front.services.service4', array_merge($data, $return_data));
    }
    public function addServiceRequest(Request $request)
    {
        $all = $request->all();
        $all['user_id'] = Auth::id();
        $service_request = ServiceRequest::create($all);
        if($service_request){
            $service = Service::select('id','name','seller_id')->where('id', $request->service_id)->first();
           
            $serviceTime = "";
            foreach ($request->time as $key => $time) {
                $serviceTime.= config('constant.SERVICE_TIMING')[$time];
                if(count($request->time) > 1 && $key < array_key_last($request->time)){
                    $serviceTime.= ", ";
                }
            }

            $email = $request->email;
            $details = $all;
            unset($details['email']);
            $details['time'] = $serviceTime;
            $details['service'] = $service->name;
            $details['sender_email'] = $email;
            $details['email'] = $service->seller->email;
            $details['subject'] = "Service Request";

            dispatch(new \App\Jobs\SendServiceRequestJob($details));

            $t_details['email'] = $email;
            $t_details['name'] = $request->name;
            $t_details['subject'] = "Thank you";
            dispatch(new \App\Jobs\SendThankYouJob($t_details));
        }

        return redirect()->route('service')->with('success', 'Request sent successfully!');
    }
    public function filters(Request $request)
    {
        $data = array();
         if($request->ajax()){
            $view = $this->fetchProducts($request);
            return response()->json(['html' => $view ,'services_count'=>$this->services_count]);
         }else{

                $serviceCategories = ServiceCategory::where('status',1)->limit(8)->orderBy('updated_at','DESC')->get(); 
                $slug = ServiceCategory::where('id',$request->category)->where('status',1)->first()->slug;
                $services = Service::where('status',1)->where('service_category_id',$request->category)->Where('time', 'like', '%' . $request->time . '%')->whereBetween('price', [$request->max_price,$request->min_price])->get();
                $max_amount =  $services->max('price');
                $max_amount = round($max_amount);
                $return_data['categories'] = $this->categories;
                $services_count = $services->count();
                return view('front.services.service-details', array_merge($data, $return_data),compact('serviceCategories','services','max_amount','slug','services','services_count'));
            }
       
    }

    public function fetchProducts(Request $request)
    {

        $data = array();
        $services = array();
        $this->services_count = 0;
        if((empty($request->time_ids) && empty($request->cat_ids)) ||  empty($request->cat_ids))
        {
            $view = view('front.services.services-list',compact('services'))->render();
            return $view;
        }
        $services = Service::where('status',1);
            
        if($request->cat_ids){
            $services = $services->whereIn('service_category_id',$request->cat_ids);
        }
        if($request->time_ids){
            // $time = implode(",",$request->time_ids);
            $services = $services->whereRaw('json_contains(time, \'' . json_encode($request->time_ids) . '\')');
        }
        if($request->max_price)
        {
            $services = $services->whereBetween('price', [$request->min_price, $request->max_price]);
        }   
            $this->services_count = $services->count();
            $services = $services->get();
             
        if (empty($services)) {
            abort(404);
        } 
        $view = view('front.services.services-list',compact('services'))->render();
        return $view;

    }
}
