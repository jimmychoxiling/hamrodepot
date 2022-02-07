<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\NotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->data['countries'] = Country::all();

        view()->share(array_merge($this->data));

        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function registerSeller(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'last_name' => ['required'],
            'business_name' => ['required']
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
//        if(isset($data['business_name'])){
//            $data['slug'] = Str::slug($data['business_name'],'-');
//        }
        $data['status'] = 2;
        $user = User::create($data);
        $user = $user->assignRole(['Seller']);
        NotificationHelper::userRegister($user);
        Auth::loginUsingId($user->id);
        return redirect()->route('home')
            ->with('success', 'Registered Successfully!');
    }

    public function registerUser(Request $request)
    {

        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'last_name' => ['required'],
        ]);

        $data = $request->all();

        $data['password'] = Hash::make($data['password']);
        $data['status'] = 1;

        $user = User::create($data);
        $user = $user->assignRole(['User']);
        $this->storeAddress($user, $request);
        NotificationHelper::userRegister($user);
        Auth::loginUsingId($user->id);
        return redirect()->route('home')
            ->with('success', 'Registered Successfully!');
    }

    public function storeAddress(User $user, Request $request)
    {
        $data = $request->all();
        $data['address_type'] = 1;
        $data['delivery_type'] = 1;
        $data['default_address'] = 1;
        $data['user_id'] = $user->id;
        $address = UserAddress::create($data);
    }
}
