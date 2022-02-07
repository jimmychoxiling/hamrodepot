<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Country;
use App\Models\SellerOpeningHour;
use App\Repositories\SellerRepository;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $sellerRepository;

    public function __construct(SellerRepository $sellerRepository)
    {
        $this->sellerRepository = $sellerRepository;
    }
    /**
     * Show the form for editing the profile.
     *
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        $countries = Country::get();
        $hours =  SellerOpeningHour::where('user_id', '=', auth()->user()->id)->get();
        if (count($hours) == 0) {
            $hours = $this->sellerRepository->getDefaultHours();
        }
        return view('Backend.profile.index', compact('countries', 'hours'));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        //        if (auth()->user()->id == 1) {
        //            return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        //        }

        auth()->user()->update($request->all());

        return back()->withStatus(__('Profile successfully updated.'));
    }

    /**
     * Change the password
     *
     * @param  \App\Http\Requests\PasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function password(PasswordRequest $request)
    {
//        if (auth()->user()->id == 1) {
//            return back()->withErrors(['not_allow_password' => __('You are not allowed to change the password for a default user.')]);
//        }

        auth()->user()->update(['password' => Hash::make($request->get('password'))]);

        return back()->withPasswordStatus(__('Password successfully updated.'));
    }
}
