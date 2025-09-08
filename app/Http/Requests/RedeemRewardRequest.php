<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RedeemRewardRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'reward_id' => 'required|exists:rewards,id',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'O cliente é obrigatório.',
            'client_id.exists'   => 'Cliente não encontrado.',
            'reward_id.required' => 'O prêmio é obrigatório.',
            'reward_id.exists'   => 'Prêmio inválido.',
        ];
    }
}
