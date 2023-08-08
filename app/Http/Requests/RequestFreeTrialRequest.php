<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFreeTrialRequest extends FormRequest
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
            'email' => ['required', 'unique:test_orders,email', 'unique:users,email', 'max:255'],
            'meio_contato' => ['required', 'max:255'],
            'contato' => ['required', 'max:255'],
            'msg' => ['nullable', 'max:1000'],
        ];
    }

    public function attributes()
    {
        return [
            'msg' => 'mensagem'
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => 'O e-mail já foi cadastrado',
        ];
    }
}
