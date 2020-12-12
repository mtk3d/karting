<?php

namespace App\GoCart;

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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|uuid',
            'name' => 'required|max:100|min:3',
            'description' => 'present',
            'available' => 'boolean',
        ];
    }
}
