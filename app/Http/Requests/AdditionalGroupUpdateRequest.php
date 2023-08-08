<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdditionalGroupUpdateRequest extends FormRequest
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
            'nome' => ['required', 'max:255'],
            'descricao' => ['nullable', 'max:1000'],
            'adicional_qtd_min' => ['nullable', 'numeric', 'max:9999999999'],
            'adicional_qtd_max' =>  ['nullable', 'numeric', 'max:9999999999'],
            'adicional_juncao' => ['required', 'in:SOMA,DIVIDIR,MEDIA'],
            'ordem_interna' => ['nullable'],
        ];
    }

    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'adicional_qtd_min' => 'Qtd. Mínima',
            'adicional_qtd_max' => 'Qtd. Máxima',
            'adicional_juncao' => 'junção',
        ];
    }
}
