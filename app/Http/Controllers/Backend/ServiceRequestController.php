<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use DataTables;
use Auth;

class ServiceRequestController extends Controller
{
    public function index()
    {
        return view('Backend.service-request.index');
    }
    public function getServiceRequest(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = ServiceRequest::latest()->get();
            } else {
                $data = ServiceRequest::with(['service' => function($query){
                    $query->where('seller_id', auth()->user()->id);
                }])->whereHas('service', function($query){
                    $query->where('seller_id', auth()->user()->id);
                })->latest()->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('service_id', function ($row) {
                    return $row->service->name;
                })
                ->addColumn('budget', function ($row) {
                    return $row->budget ? config('constant.CURRENCY_SIGN').$row->budget : '-';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-info  btn-sm" href="'. route('service-request.show', ['id' => base64_encode($row->id)]) .'"><i class="fa fa-eye"></i></a>';
                    
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function show($id){
        $id = base64_decode($id);
        if (Auth::user()->hasRole('Admin')) {
            $service = ServiceRequest::where('id', $id)->first();
        } else {
            $service = ServiceRequest::with(['service' => function($query){
                $query->where('seller_id', auth()->user()->id);
            }])->whereHas('service', function($query){
                $query->where('seller_id', auth()->user()->id);
            })->first();
        }

        return view('Backend.service-request.show', compact('service'));
    }
}
