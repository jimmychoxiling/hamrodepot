<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\Country;
use App\Models\UserAddress;
use App\Repositories\UserAddressRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    private $userRepository;
    private $userAddressRepository;

    public function __construct(UserRepository $userRepository, UserAddressRepository $userAddressRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->userAddressRepository = $userAddressRepository;
    }

    public function myAccount()
    {
        $data = array();

        $user = Auth()->user();
        $countries = Country::get();

        $return_data['categories'] = $this->categories;
        $return_data['user'] = $user;
        $return_data['countries'] = $countries;

        return view('front.my-account.my-account', array_merge($data, $return_data));
    }

    public function updateUserDetails(Request $request)
    {
        $data = $request->all();
        $id = Auth()->user()->id;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('user');
            $data['image'] = $path;
        }

        $user = $this->userRepository->update($id, $data);

        $user_address_first = UserAddress::where('user_id',$id)->first();
        $user_address = $this->userAddressRepository->update($user_address_first->id, $data);

        return redirect()->route('my-account')
            ->with('success', 'Updated Successfully!');
    }
    public function changePassword(PasswordRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
        }
        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return redirect()->route('my-account')
            ->with('success', 'Password successfully updated!');
    }
}
