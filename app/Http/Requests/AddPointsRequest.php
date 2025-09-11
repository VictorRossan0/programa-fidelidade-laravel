<?php
/**
 * AddPointsRequest
 *
 * Validação da entrada de pontuação (006). Exige client_id válido e
 * amount_spent >= 5.
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Request para validação dos dados ao pontuar cliente.
class AddPointsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id'    => 'required|exists:clients,id',
            'amount_spent' => 'required|numeric|min:5',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'O cliente é obrigatório.',
            'client_id.exists'   => 'Cliente não encontrado.',
            'amount_spent.required' => 'O valor gasto é obrigatório.',
            'amount_spent.numeric'  => 'O valor deve ser numérico.',
            'amount_spent.min'      => 'O valor mínimo para gerar pontos é R$5,00.',
        ];
    }
}
