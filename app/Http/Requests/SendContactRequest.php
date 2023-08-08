<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest
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
            'meio_contato' => ['required', 'max:255'],
            'msg' => ['required', 'max:1000'],
        ];
    }

    public function attributes()
    {
        return [
            'msg' => 'mensagem'
        ];
    }
}
