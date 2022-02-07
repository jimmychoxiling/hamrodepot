<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\UserRequest;
use App\Repositories\UserRepository;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    // private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Backend.users.index');
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::whereHas('roles', function ($q) {
                return $q->where('name', 'User');
            })->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name.' '.$row->last_name;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-info  btn-sm" href="' . route('user-show', $row->id) . '"><i class="fa fa-eye"></i></a>
                          <a href="' . route('user-edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-pen"></i></a>
                          <a href="javascript:void(0);" data-href="' . route('user-delete', $row->id) . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
        return view('Backend.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $usersRequest)
    {
        $data = $usersRequest->validated();

        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->create($data);
        $user->assignRole('User');

        return redirect()->route('user')
            ->with('success', 'User Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('Backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRole = $user->roles->pluck('id','id')->all();


        return view('Backend.users.edit', compact('user','roles','userRole'));
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
        ]);

        $data = $request->all();

        $users = $this->userRepository->update($id, $data);

        return redirect()->route('user')
            ->with('success', 'Users Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = $this->userRepository->delete($id);

        return redirect()->route('user')
            ->with('success', 'Users deleted successfully');
    }

}
