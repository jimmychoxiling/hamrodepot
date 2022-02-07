<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\PasswordRequest;
use App\Models\Country;
use App\Models\SellerOpeningHour;
use App\Models\User;
use App\Repositories\SellerRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
        return view('Seller.profile.edit', compact('countries', 'hours'));
    }

    /**
     * Update the profile
     *
     * @param  \App\Http\Requests\ProfileRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if (auth()->user()->id == 1) {
            return back()->withErrors(['not_allow_profile' => __('You are not allowed to change data for a default user.')]);
        }
        $data = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('user');
            $data['image'] = $path;
        }


        $user = User::findOrFail(auth()->user()->id);
        if (isset($data['image'])) {
            Storage::delete($user->image);
        }

        auth()->user()->update($data);

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


    public function updateHours(Request $request)
    {
        // dd($request->opening_time);
        $open_times = $request->opening_time;
        $close_times = $request->closing_time;
        $ids = $request->id;

        foreach ($this->days as $key => $day) {
            $hour = new SellerOpeningHour();
            $open =  'isOpen' . $key;
            $hour['day'] = $day;

            if ($request[$open] == 'on') {
                $hour['isOpen'] = 1;
            } else {
                $hour['isOpen'] = 0;
            }
            $hour['opening_time'] = $open_times[$key];
            $hour['closing_time'] = $close_times[$key];
            $hour['user_id'] = auth()->user()->id;
            if (count($ids) > 0 && $ids[$key]) {
                SellerOpeningHour::where('id', '=', $ids[$key])->update($hour->toArray());
            } else {
                $hour->save([$hour]);
            }
        }

        return back()->withStatus(__('Profile successfully updated.'));
    }
}
