<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\SettingRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SettingContoller extends Controller
{
    private $settingRepository;

    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    public function index()
    {
        return view('Backend.setting.index');
    }

    public function getSetting(Request $request)
    {
        if ($request->ajax()) {
            $data = Setting::get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('setting-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function edit($id)
    {
        $setting = Setting::find($id);

        return view('Backend.setting.edit', compact('setting'));
    }

    public function update(SettingRequest $settingRequest, $id)
    {
        $data = $settingRequest->validated();

        $blog = $this->settingRepository->update($id, $data);

        return redirect()->route('setting')
            ->with('success', 'Setting Updated Successfully!');
    }
}
