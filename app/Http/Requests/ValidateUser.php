<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUser extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'validation_token' => ['required', 'string', 'exists:users,validation_token'],
            'password'         => ['required', 'string', 'min:6'],
        ];
    }
}
