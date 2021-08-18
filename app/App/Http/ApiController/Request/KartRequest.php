<?php

namespace Karting\App\Http\ApiController\Request;

use Illuminate\Foundation\Http\FormRequest;

class KartRequest extends FormRequest
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
            'uuid' => 'uuid',
            'name' => 'required|max:100|min:3',
            'description' => 'present',
            'enabled' => 'boolean',
            'price' => 'required|integer|min:0',
        ];
    }
}
