<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitSingleSubmission extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "company" => ["required", "string"],
            "store_name" => ["required", "string"],
            "phone_number" => ["required", "string"],
            "sector" => ["required", "digits_between:0,35"],
            "address" => ["required", "string"],
            "postal_code" => ["required", "string"],
            "parish" => ["required", "string"],
            "county" => ["required", "string"],
            "district" => ["required", "string"],
            "lat" => ["required", "numeric"],
            "long" => ["required", "numeric"],
            "start_hour" => ["required", "array"],
            "end_hour" => ["required", "array"],
            "section_of_day" => ["required", "array"],
            "type" => ["required", "array"],
            "by_appointment" => ["required", "array"],
            "by_appointment_contact" => ["nullable", "array"],
            "days" => ["required", "array"],
            "firstname" => ["required", "string"],
            "lastname" => ["required", "string"],
            "contact" => ["required", "string"],
            "email" => ["required", "string"],
        ];
    }
}
