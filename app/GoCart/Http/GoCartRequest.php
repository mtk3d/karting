<?php

namespace App\GoCart\Http;

use Illuminate\Foundation\Http\FormRequest;

class GoCartRequest extends FormRequest
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
            'name' => 'required|max:100|min:3',
            'description' => 'present',
            'is_available' => 'boolean',
        ];
    }
}
