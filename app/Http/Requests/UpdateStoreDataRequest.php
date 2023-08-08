<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreDataRequest extends FormRequest
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
        $store_id = isset(auth()->user()->store_has_user->store->id) ? auth()->user()->store_has_user->store->id : 0;
        return [
            'nome' => ['required', 'unique:stores,nome,' . $store_id, 'max:255'],
            'slug_url' => ['required', 'unique:stores,nome,' . $store_id, 'max:255'],
            'logo' => ['image', 'max:2048'],
            'descricao' => ['required', 'max:1000'],
            'email' => ['required', 'email', 'max:255'],
            'telefone' => ['required', 'max:255'],
            'whatsapp' => ['required', 'max:255'],
            'empresa_aberta' => ['required', 'in:sim,nao', 'max:255'],

            'rua' => ['required', 'max:255'],
            'numero_end' => ['required', 'max:255'],
            'ponto_referencia' => ['max:255'],
            'complemento' => ['max:255'],
            'uf' => ['required', 'max:255'],
            'cidade' => ['required', 'max:255'],
            'bairro' => ['required', 'max:255'],
            'cep' => ['required', 'formato_cep', 'max:255'],

            'url_facebook' => ['max:255'],
            'url_twitter' => ['max:255'],
            'url_instagram' => ['max:255'],
        ];
    }

    public function attributes()
    {
        return [
            'slug_url' => 'url',
            'descricao' => 'descrição',
        ];
    }
}
