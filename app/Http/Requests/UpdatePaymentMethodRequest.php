<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
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
            "tipo" => ['required', 'in:DINHEIRO,CARTAO,GATEWAY,OUTROS,BOLETO'],
            "icone" => ['required', 'max:255'],
            "classe" => ['required', 'in:secondary,primary,danger,warning,dark,success'],
            "ativo" => ['required:S,N'],
        ];
    }

    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'icone' => 'ícone',
            'classe' => 'esquema',
        ];
    }
}
