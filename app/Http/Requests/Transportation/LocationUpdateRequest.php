<?php

namespace App\Http\Requests\Transportation;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationUpdateRequest extends FormRequest
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
            'name' => ['bail', 'required', Rule::unique('locations')->ignore($this->location)->where('type', $this->type)],
        ];
    }
}