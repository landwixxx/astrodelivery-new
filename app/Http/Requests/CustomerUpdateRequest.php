<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'cpf' => ['nullable', 'cpf', 'max:255'],
            'telefone' => ['required', 'celular_com_ddd', 'max:255'],
            'whatsapp' => ['required', 'celular_com_ddd', 'max:255'],
            'dt_nascimento' => ['nullable', 'date', 'before:tomorrow'],
            'endereco' => ['required', 'max:255'],
            'numero_end' => ['required', 'max:255'],
            'ponto_referencia' => ['max:255'],
            'complemento' => ['max:255'],
            'estado' => ['required', 'max:255'],
            'cidade' => ['required', 'max:255'],
            'bairro' => ['required', 'max:255'],
            'cep' => ['required', 'formato_cep', 'max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'cpf' => 'CPF',
            'endereco' => 'endereço',
            'numero_end' => 'número de endereço',
            'ponto_referencia' => 'ponto de referência',
            'cep' => 'CEP',
            'dt_nascimento' => 'data de nascimento',
        ];
    }

    public function messages()
    {
        return [
            'before' => 'O campo data de nascimento deve ser uma data anterior a data atual.'
        ];
    }
}
