<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use App\Http\Requests\Backend\VouchersRequest;
use App\Repositories\VoucherRepository;
use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Auth;


class VouchersController extends Controller
{

    public function __construct(VoucherRepository $voucherRepository){
        $this->voucherRepository = $voucherRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vouchers = Voucher::all();
        return view('Backend.vouchers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Backend.vouchers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VouchersRequest $vouchersRequest)
    {
        $data = $vouchersRequest->validated();
        $data['status'] =  1;
        $voucher = $this->voucherRepository->create($data);
        return redirect()->route('voucher')
            ->with('success', 'Discount Coupon Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $voucher = Voucher::find($id);
        return view('Backend.vouchers.show', compact('voucher'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $voucher = Voucher::find($id);
        return view('Backend.vouchers.edit', ['voucher' => $voucher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $this->validate($request, [
            'name' => 'required',
            'type' => 'required',
            'order_amount' => 'required',
            'discount_amount' => 'required',
            'starts_at' => 'nullable|required_with:expires_at',
            'expires_at' => 'nullable|required_with:starts_at|after:starts_at',
        ]);

        $data = $request->all();
        $voucher = $this->voucherRepository->update($id, $data);

        return redirect()->route('voucher')
            ->with('success', 'Discount Coupon Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }

    public function getVoucher(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::user()->hasRole('Admin')) {
                $data = $data = Voucher::latest()->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('type', function ($row) {
                    return $row->type;
                })
                ->addColumn('order_amount', function ($row) {
                    return $row->order_amount;
                })
                ->addColumn('discount_amount', function ($row) {
                    return $row->discount_amount;
                })
                ->addColumn('starts_at', function ($row) {
                    return $row->starts_at;
                })
                ->addColumn('expires_at', function ($row) {
                    return $row->expires_at;
                })
                ->addColumn('from_time', function ($row) {
                    return $row->from_time;
                })
                ->addColumn('to_time', function ($row) {
                    return $row->to_time;
                })
                ->addColumn('code', function ($row) {
                    return $row->code;
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
                            return '<div class="status-main"><span class="voucher-badge badge badge-pill badge-' . $class . '">Active</span></div>';
                        case '2':
                            return '<div class="status-main"><span class="voucher-badge badge badge-pill badge-' . $class . '">InActive</span></div>';
                        case '3':
                            return '<div class="status-main"><span class="voucher-badge badge badge-pill badge-' . $class . '">Reject</span></div>';
                        default:
                            return '<div class="status-main"><span class="voucher-badge badge badge-pill badge-' . $class . '">Pending</span></div>';
                    }
                })
                ->addColumn('action', function ($row) {
                    $checked = "";
                    $display = "";
                    $statusBtn = "";
                    $currentDate = date('Y-m-d');
                    if ($row->status == 1 || $row->status == 2) {

                        if ($row->status == 1) {
                            $checked = "checked";
                        }
                        $display = "block";
                    }

                    $actionBtn = '
                    <label class="custom-toggle" style="display: ' . $display . '">
                        <input type="checkbox" value="1" ' . $checked . ' class="statusUpdateVoucher product-status active-inactive" data-id="' . $row->id . '" >
                        <span class="custom-toggle-slider rounded-circle"></span>
                        </label>
                        <a class="btn btn-info  btn-sm" href="' . route('voucher-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('voucher-edit', $row->id) . '" class="edit btn btn-success  btn-sm"><i class="fa fa-pen"></i></a>
                          ';
                    return $statusBtn . $actionBtn;
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }
    }
    public function updateStatus(Request $request)
    {

        $voucher = Voucher::find($request->id);
        $voucher['status'] = $request->status;
        $msg = "Voucher status successfully updated";

        $voucher = Voucher::find($request->id)->update($voucher->toArray());
        $voucher = Voucher::find($request->id);
        return response()->json(['success' => true, 'message' => $msg, 'status' => $voucher['status']]);
    }
}
