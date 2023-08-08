<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductsWithAdditionalRequest extends FormRequest
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
            'product_id' => ['required', 'exists:products,id'],
            'adicionais_id.0' => ['required', 'exists:products,id']
        ];
    }

    public function messages()
    {
        return [
            'adicionais_id.0.required' => 'Selecione pelo menos um adicional'
        ];
    }

    public function attributes()
    {
        return [
            'product_id' => 'produto',
            'adicionais_id.0' => 'adicional'
        ];
    }
}
