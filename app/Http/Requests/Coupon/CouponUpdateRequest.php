<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CouponUpdateRequest extends FormRequest
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
            'package_id' => ['required'],
            'name' => ['required'],
            'discount_amount' => ['required'],
            'limit' => ['bail', 'required', 'integer'],
            'expire_date' => ['bail', 'required', 'date'],
            'code' => ['bail', 'required', 'unique:coupons,code'],
            'code' => ['bail', 'required', Rule::unique('coupons')->ignore($this->coupon)],
        ];
    }
}
