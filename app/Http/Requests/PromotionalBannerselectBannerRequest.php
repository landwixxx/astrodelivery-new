<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromotionalBannerselectBannerRequest extends FormRequest
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
            'posicao' => ['required', 'in:1,2,3,4'],
            'banner_id' => ['required', 'exists:promotional_banners,id']
        ];
    }

    public function attributes()
    {
        return [
            'posicao' => 'posição',
            'banner_id' => 'banner'
        ];
    }
}
