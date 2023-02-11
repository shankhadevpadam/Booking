<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class ReviewCreateRequest extends FormRequest
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
        $rules = [
            'title' => ['required'],
            'review' => ['required'],
            'review_date' => ['required'],
            'rating' => ['bail', 'required', 'numeric'],
            'user_id' => ['required'],
            'package_id' => ['required'],
        ];

        if ($this->hasFile('photos')) {
            $rules['photos'] = ['required'];
            $rules['photos.*'] = ['bail', 'image', 'max:2048'];
        }

        return $rules;
    }
}
