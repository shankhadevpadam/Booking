<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class PackageGroupDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'min_number_of_people' => ['bail', 'required', 'integer'],
            'max_number_of_people' => ['bail', 'required', 'integer'],
            'price' => ['required'],
        ];
    }
}
