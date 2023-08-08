<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryTypeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "nome" => ['required', 'max:255'],
            "descricao" =>  ['nullable', 'max:1000'],
            "tipo" => ['required', 'in:Balcão,Delivery,Mesa,Correios'],
            "icone" => ['required', 'max:255'],
            "classe" => ['required', 'in:secondary,primary,danger,warning,dark'],
            "valor" => ['required', 'numeric', 'min:0.00', 'max:999999999'],
            "valor_minimo" => ['required', 'numeric', 'min:0.00', 'max:999999999'],
            "tempo" => ['nullable', 'regex:/^[0-9][0-9]:[0-5][0-9]:[0-5][0-9]$/'],
            "ativo" => ['required:S,N'],
            "bloqueia_sem_cep" => ['required:S,N'],
            'metodos_pagamento.0' => ['required']
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $valor = currency_to_decimal($this->input('valor') == null ? '' : $this->input('valor'));
        session()->flash('valor', $valor);

        $valor_minimo = currency_to_decimal($this->input('valor_minimo') == null ? '' : $this->input('valor_minimo'));
        session()->flash('valor_minimo', $valor_minimo);

        $this->merge([
            'valor' => $valor,
            'valor_minimo' => $valor_minimo,
        ]);
    }
}
