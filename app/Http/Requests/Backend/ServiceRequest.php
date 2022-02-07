<?php

namespace App\Http\Requests\Backend;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'service_category_id' => 'required',
            'time' => 'required',
            'description' => 'required',
            'tag' => 'nullable',
            'status' => 'nullable',
            'image' => 'nullable',
            'id' => 'nullable',
            'price' => 'required',
        ];
    }
}
