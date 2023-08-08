<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FlavorUpdateRequest extends FormRequest
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
            'nome' => ["required", "max:255"],
            'descricao' => ['required', 'max:500'],
            'type_flavor_id' => ['required', 'exists:type_flavors,id'],
            'foto' => ['nullable', 'image:', 'mimes:jpg,jpeg,png,gif,bmp,webp']
        ];
    }

    public function attributes()
    {
        return [
            'descricao' => 'descrição',
            'type_flavor_id' => 'tipo de sabor',
        ];
    }
}
