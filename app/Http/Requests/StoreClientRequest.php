<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Request para validação dos dados ao cadastrar cliente.
class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return true; // já validamos no middleware
    }

    public function rules()
    {
        return [
            'name'  => 'required|string|min:3|max:100',
            'email' => 'required|email|unique:clients,email',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome do cliente é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Forneça um email válido.',
            'email.unique' => 'Este email já está cadastrado.',
        ];
    }
}
