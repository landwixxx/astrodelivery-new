<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComboProductStoreRequest extends FormRequest
{

    protected $preco = null;
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
            'descricao' => ['required', 'max:2000'],
            'category_id' => ['required', 'exists:categories,id'],
            'preco' => ['required', 'numeric', 'max:999999999'],
            'qtd_estoque' => ['nullable', 'numeric', 'max:999999999'],
            'qtd_min_ped' => ['required', 'numeric', 'max:999999999', 'min:1'],
            'imagem_prod.0' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,bmp,webp'],
            'cod_barras' => ['nullable', 'max:255'],
            'cod_empresa' => ['nullable', 'max:255'],
            'produtos_combo_id' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'nome do produto',
            'descricao' => 'descrição',
            'category_id' => 'categoria',
            'preco' => 'preço',
            'qtd_estoque' => 'qtd. estoque',
            'qtd_min_ped' => 'qtd .mínima do pedido',
            'imagem_prod.0' => 'imagem',
            'cod_barras' => 'código de barras',
            'cod_empresa' => 'código na empresa',
        ];
    }

    public function messages()
    {
        return [
            'produtos_combo_id.required' => 'Produtos do combo é obrigatório'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $preco = currency_to_decimal($this->input('preco'));
        session()->flash('preco', $preco);
        $this->merge([
            'preco' => $preco,
        ]);
    }
}
