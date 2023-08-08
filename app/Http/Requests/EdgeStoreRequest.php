<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EdgeStoreRequest extends FormRequest
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
            'descricao' => ['required', 'max:500'],
            'preco' => ['required', 'numeric', 'max:999999999']
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'nome',
            'descricao' => 'descrição',
            'preco' => 'preço',
        ];
    }

    protected function prepareForValidation()
    {
        // $valor= !is_null($this->input('preco')) ? $this->input('preco') : '0';
        $preco = null;
        if (!is_null($this->input('preco')))
            $preco = currency_to_decimal($this->input('preco'));

        session()->flash('preco', $preco);
        $this->merge([
            'preco' => $preco,
        ]);
    }
}
