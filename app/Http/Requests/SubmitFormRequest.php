<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitFormRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'firstname' => ['required','string'],
            'lastname' => ['required','string'],
            'email' => ['required','email'],
            'contact' => ['required','string']
        ];
    }
}
