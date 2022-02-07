<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ProductsRequest extends FormRequest
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
            'seller_id' => ['nullable'],
            'name' => ['required'],
            'sku' => ['required'],
            'description' => ['required'],
            'sell_type' => ['required'],
            'price' => ['required'],
            'stock' => ['required'],
            'brands_id' => ['required'],
            'product_overview' => ['nullable'],
            'specifications' => ['nullable'],
            'easy_returns' => ['nullable'],
            'status' => ['nullable'],
        ];
    }
}
