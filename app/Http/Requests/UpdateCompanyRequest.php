<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'cnpj' => ['required', 'cnpj', 'max:255'],
            'fantasia' => ['required', 'max:255'],
            'razao_social' => ['required', 'max:255'],
            'telefone' => ['required', 'max:255'],
            'whatsapp' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nome_contato' => ['max:255'],
            'telefone_contato' => ['required', 'max:255'],
            'endereco' => ['required', 'max:255'],
            'numero_end' => ['required', 'max:255'],
            'ponto_referencia' => ['max:255'],
            'complemento' => ['max:255'],
            'uf' => ['required', 'max:255'],
            'cidade' => ['required', 'max:255'],
            'bairro' => ['required', 'max:255'],
            'cep' => ['required', 'formato_cep', 'max:255'],
            'sobre' => ['required', 'max:3000'],

            'cnae' => ['max:255'],
            'insc_estadual' => ['max:255'],
            'insc_estadual_subs' => ['max:255'],
            'insc_municipal' => ['max:255'],
            'cod_ibge' => ['max:255'],
            'regime_tributario' => ['nullable', 'in:simples_nacional,lucro_presumido,lucro_real', 'max:255'],
        ];
    }

    function attributes()
    {
        return [
            'cnpj' => 'CNPJ',
            'razao_social' => 'razão social',
            'nome_contato' => 'nome de contato',
            'telefone_contato' => 'telefone de contato',
            'endereco' => 'endereço',
            'numero_end' => 'número de endereço',
            'ponto_referencia' => 'ponto de referência',
            'uf' => 'UF',
            'cep' => 'CEP',
            'cnae' => 'CNAE',
            'insc_estadual' => 'insc. estadual',
            'insc_estadual_subs' => 'insc. estadual subs.',
            'insc_municipal' => 'insc. municipal',
            'cod_ibge' => 'cód. IBGE',
            'regime_tributario' => 'regime tributário',
        ];
    }
}
