<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'foto' => ['required', 'image:', 'mimes:jpg,jpeg,png,gif,bmp,webp'],
            'ativo' => ['required', 'in:S,N']
        ];
    }

    public function attributes()
    {
        return [
            'nome' => 'nome da categoria',
            'descricao' => 'descrição',
        ];
    }
}
