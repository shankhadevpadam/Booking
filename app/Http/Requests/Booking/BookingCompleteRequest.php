<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingCompleteRequest extends FormRequest
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
            'trekkers_details.*.fullName' => ['required'],
            'trekkers_details.*.email' => ['bail', 'required', 'email'],
            'passport' => ['required'],
            'passport.*' => ['bail', 'mimes:jpg,bmp,png,pdf', 'max:2048'],
            'emergency_phone' => ['required'],
            'emergency_email' => ['bail', 'required', 'email'],
            'appointment_date' => ['bail', 'required', 'date_format:Y-m-d'],
            'appointment_time' => ['bail', 'required', 'required_with:appointment_date', 'date_format:h:i A'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'trekkers_details.*.fullname.required' => 'The fullname field is required.',
            'trekkers_details.*.email.required' => 'The email field is required.',
            'trekkers_details.*.email.email' => 'The email must be a valid email address.',
            'passport.*.mimes' => 'The passport must be image or pdf file.',
            'passport.*.max' => 'The passport size must be less than 2MB.',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'trekkers_details' => json_decode(request('trekkers_details'), true),
        ]);
    }
}
