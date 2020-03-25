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
            'nome' => 'required',
            'apelido' => 'required',
            'email' => 'required',
            'telefone' => 'required',
            'nome_empresa' => 'required',
        ];
    }
}
