<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class PackageAddonUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'addon_package_id' => ['required'],
            'price' => ['bail', 'required', 'numeric'],
            'discount_amount' => ['bail', 'nullable', 'numeric'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->sometimes('cover_picture', ['bail', 'image', 'max:2048'], function ($input) {
            return $input->hasFile('cover_picture');
        });
    }
}
