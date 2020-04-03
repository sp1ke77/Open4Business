<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "firstname" => ['nullable','string'],
            "lastname" => ['nullable','string'],
            "position" => ['nullable','string'],
            "company" => ['nullable','string'],
            "contact" => ['nullable','string'],
            "email" => ['required','email','unique:users'],
        ];
    }
}
