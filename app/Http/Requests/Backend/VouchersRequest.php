<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class VouchersRequest extends FormRequest
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
            'type' => 'required',
            'order_amount' => 'required',
            'discount_amount' => 'required',
            'starts_at' => 'nullable|required_with:expires_at',
            'expires_at' => 'nullable|required_with:starts_at|after:starts_at',
            'code' => 'required|unique:vouchers|alpha_dash|min:5|max:10',
        ];
    }
}
