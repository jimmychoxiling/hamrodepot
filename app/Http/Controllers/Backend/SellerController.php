<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SellerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\Country;
use App\Repositories\SellerRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SellerController extends Controller
{
    private $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.seller.index');
    }

    public function getSeller(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereHas('roles', function ($q) {
                return $q->where('name', 'Seller');
            })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name . ' ' . $row->last_name;
                })
                ->addColumn('status', function ($row) {
                    if ($row->status == 1) {
                        return '<div class="status-main"><span class="seller-badge badge badge-pill badge-success">Active</span></div>';
                    } else {
                        return '<div class="status-main"><span class="seller-badge badge badge-pill badge-danger">InActive</span></div>';
                    }
                })
                ->addColumn('commision', function ($row) {
                    $checked = "";
                    if ($row->status == 1) {
                        $checked = "checked";
                    }

                    $actionBtn = '
                            <input type="text" name="admin_commission" id="input-admin_commission" class="admin_commission form-control form-control-alternative" placeholder="Enter seller commision" value="'.$row->admin_commission.'" required="" data-parsley-required-message="Value is required">
                            <button type="submit" data-id="' . $row->id . '" class="btn btn-success btn-sm mt-4 UpdateSellerCommission">Update</button>';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $checked = "";
                    if ($row->status == 1) {
                        $checked = "checked";
                    }
                    $statusBtn = '<label class="custom-toggle">
                    <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateSeller seller-status active-inactive" data-id="' . $row->id . '" >
                    <span class="custom-toggle-slider rounded-circle"></span>
                    </label> <br>';

                    $actionBtn = '
                        <a class="btn btn-info  btn-sm" href="' . route('seller-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('seller-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-href="' . route('seller-delete', $row->id) . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $statusBtn . $actionBtn;
                })
                ->rawColumns(['name', 'status', 'action','commision'])
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
        $roles = Role::all();
        $countries = Country::all();
        $seller = new User();
        $url = 'seller-store';
        return view('Backend.seller.seller-form', compact('roles', 'countries', 'seller', 'url'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellerRequest $whosalerRequest)
    {
        $data = $whosalerRequest->validated();

        $data['password'] = Hash::make($data['password']);
        //        $data['slug'] = Str::slug($data['business_name'], '-');

        if ($whosalerRequest->hasFile('image')) {
            $file = $whosalerRequest->file('image');
            $path = $file->store('user');
            $data['image'] = $path;
        }

        $seller = $this->sellerRepository->create($data);

        $seller->assignRole('Seller');

        return redirect()->route('seller')
            ->with('success', 'Seller Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = User::with('country')->find($id);

        return view('Backend.seller.show', compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = User::find($id);
        $countries = Country::all();
        $url = 'seller-update';
        return view('Backend.seller.seller-form', compact('seller', 'countries', 'url'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            // 'phone' => 'required',
            // 'address' => 'required',
            // 'zipcode' => 'required',
            // 'city' => 'required',
            // 'state' => 'required',
            // 'countries_id' => 'required',
        ]);

        $data = $request->all();
        //        $data['slug'] = Str::slug($data['business_name'], '-');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('user');
            $data['image'] = $path;
        }

        $seller = $this->sellerRepository->update($id, $data);

        return redirect()->route('seller')
            ->with('success', 'Seller Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $seller = $this->sellerRepository->delete($id);

        return redirect()->route('seller')
            ->with('success', 'Seller deleted successfully');
    }


    public function updateStatus(Request $request)
    {
        $seller = User::find($request->id);
        if ($seller->status == 1) {
            $seller['status'] = 2;
        } else {
            $seller['status'] = 1;
        }
        $seller = $seller->update([$seller]);
        $seller = User::find($request->id);
        return response()->json(['success' => true, 'message' => 'User status successfully updated', 'status' => $seller['status']]);
    }

    public function updateCommission(Request $request){

        $seller = User::find($request->id);
        if ($seller) {
            $seller['admin_commission'] = $request->admin_commission;
            $seller = $seller->update([$seller]);
            $seller = User::find($request->id);
            return response()->json(['success' => true, 'message' => 'User commission successfully updated', 'admin_commission' => $seller['admin_commission']]);
        }
        return response()->json(['warning' => true, 'message' => 'Somthing wrong..!']);
    }
}
