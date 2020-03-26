<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateNewUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ['required','string'],
            "email" => ['required','email','unique:users'],
            "password" => ['required','string','min:6'],
            "type" => ['required','numeric','between:0,1']
        ];
    }
}
