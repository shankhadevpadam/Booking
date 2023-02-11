<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class PackageAddonCreateRequest extends FormRequest
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
            'cover_picture' => ['bail', 'required', 'image', 'max:2048'],
        ];
    }
}
