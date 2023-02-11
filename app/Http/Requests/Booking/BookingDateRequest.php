<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class BookingDateRequest extends FormRequest
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
            'arrival_date' => ['bail', 'nullable', 'date_format:Y-m-d'],
            'arrival_time' => ['bail', 'nullable', 'required_with:arrival_date', 'date_format:h:i A'],
            'flight_number' => ['bail', 'nullable', 'required_with:arrival_date'],
            'photograph' => ['bail', 'nullable', 'required_with:arrival_date', 'image', 'max:2048'],
            'group_dates.*.arrivalDate' => ['bail', 'nullable', 'date_format:Y-m-d'],
            'group_dates.*.arrivalTime' => ['bail', 'nullable', 'required_with:group_dates.*.arrival_date', 'date_format:h:i A'],
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
            'group_dates.*.arrivalDate.date_format' => 'The arrival date does not match the format Y-m-d.',
            'group_dates.*.arrivalTime.required_with' => 'The arrival time field is required when arrival time is present.',
            'group_dates.*.arrivalTime.date_format' => 'The arrival time does not match the format h:i A.',
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
            'group_dates' => json_decode(request('group_dates'), true),
        ]);
    }
}
