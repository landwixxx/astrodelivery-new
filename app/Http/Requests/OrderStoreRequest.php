<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'delivery_type_id' => ['required', 'exists:delivery_types,id'],
            'estado' => ['nullable', 'max:255'],
            'cidade' => ['nullable', 'max:255'],
            'bairro' => ['nullable', 'max:255'],
            'rua' => ['nullable', 'max:255'],
            'numero' => ['nullable', 'max:255'],
            'cep' => ['nullable', 'formato_cep', 'max:255', 'max:255'],
            'complemento' => ['nullable', 'max:255'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'delivery_table_id' => ['nullable', 'exists:delivery_tables,id']
        ];
    }

    public function attributes()
    {
        return [
            'numero' => 'número',
            'cep' => 'CEP'
        ];
    }
}
