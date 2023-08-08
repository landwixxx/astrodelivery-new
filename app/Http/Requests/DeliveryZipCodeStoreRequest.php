<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryZipCodeStoreRequest extends FormRequest
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
            'cep_ini' => ['required', 'formato_cep'],
            'cep_fim' =>  ['required', 'formato_cep'],
            'valor' => ['required', 'numeric', 'max:999999999'],
            'status' => ['required', 'in:ativo,desativado'],
            'tipo_entrega_id' => ['required', 'exists:delivery_types,id'],
        ];
    }

    public function attributes()
    {
        return [
            'cep_ini' => 'CEP inicial',
            'cep_fim' => 'CEP final',
            'tipo_entrega_id' => 'tipo de entrega',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $valor = null;
        if ($this->input('valor') != null)
            $valor = currency_to_decimal($this->input('valor'));
        session()->flash('valor', $valor);

        $this->merge([
            'valor' => $valor,
        ]);
    }
}
