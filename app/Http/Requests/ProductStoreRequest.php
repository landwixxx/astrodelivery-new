<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'tipo' => ['required', 'in:PRODUTO,ADICIONAL'],
            'nome' => ['required', 'max:255'],
            'sub_nome' => ['required', 'max:255'],
            'cor_sub_nome' => ['required'],
            'descricao' => ['nullable', 'max:2000'],
            'codigo_empresa' => ['nullable', 'max:255'],
            'codigo_barras' => ['nullable', 'max:255'],
            'codigo_barras_padrao' => ['nullable', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'valor_original' => ['required', 'numeric', 'max:99999999999'],
            'valor' => ['required', 'numeric', 'max:99999999999'],
            'estoque' => ['nullable', 'numeric'],
            'ordem' => ['nullable', 'numeric'],
            'limitar_estoque' => ['required', 'in:S,N'],
            'fracao' => ['required', 'in:S,N'],
            'item_adicional' => ['required', 'in:S,N'],
            'item_adicional_obrigar' => ['required', 'in:S,N'],
            'item_adicional_multi' => ['required', 'in:S,N'],
            'adicional_qtde_min' => ['nullable', 'numeric'],
            'adicional_qtde_max' => ['nullable', 'numeric'],
            'adicional_juncao' => ['required', 'in:SOMA,DIVIDIR,MEDIA'],
            'grupo_adicional_id' => ['nullable', 'exists:additional_groups,id'],
            'imagem_prod.0' => ['required', 'image', 'mimes:jpg,jpeg,png,gif,bmp,webp'],
        ];
    }

    public function attributes()
    {
        return [
            'cor_sub_nome' => 'cor subnome',
            'descricao' => 'descrição',
            'codigo_empresa' => 'código na empresa',
            'codigo_barras' => 'código de barras',
            'codigo_barras_padrao' => 'padrão código barras',
            'category_id' => 'categoria',
            'fracao' => 'fração',
            'item_adicional_obrigar' => 'obrigar item adicional',
            'adicional_qtde_min' => 'adicional qtd. mínima',
            'adicional_qtde_max' => 'adicional qtd. máxima',
            'adicional_juncao' => 'adicional junção',
            'grupo_adicional_id' => 'grupo de adicional',
            'imagem_prod.0' => 'imagem do produto',
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $valor_original = null;
        if ($this->input('valor_original') != null)
            $valor_original = currency_to_decimal($this->input('valor_original'));
        session()->flash('valor_original', $valor_original);

        $valor = null;
        if ($this->input('valor') != null)
            $valor = currency_to_decimal($this->input('valor'));
        session()->flash('valor', $valor);

        $this->merge([
            'valor_original' => $valor_original,
            'valor' => $valor,
        ]);
    }
}
