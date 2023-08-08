<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryTableStoreRequest extends FormRequest
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
            'tipo_entrega_id' => ['required', 'exists:delivery_types,id'],
            'mesa' => ['required', 'max:255'],
            'descricao' => ['nullable', 'max:1000'],
            'status' => ['required', 'in:ativo,desativado'],
        ];
    }

    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'tipo_entrega_id' => 'tipo de entrega'
        ];
    }
}
