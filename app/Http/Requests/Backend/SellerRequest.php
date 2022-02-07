<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class SellerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'business_name' => 'required',
            'shipping_method' => 'required',
            'product_plan_to_list' => 'required',
            'country_id' => 'required',
            'phone_number' => 'required',
            'zipcode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'gender' => 'required',
            'status' => 'required',
            'address_line1' => 'required',
            'address_line2' => 'nullable',
        ];
    }
}
