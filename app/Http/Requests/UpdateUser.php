<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

class UpdateUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "id" => ['required','exists:users'],
            "name" => ['required','string'],
            "email" => ['required','email',ValidationRule::unique('users')->ignore($this->id)],
            "password" => ['nullable','string','min:6'],
            "type" => ['required','integer','between:0,1']
        ];
    }
}
