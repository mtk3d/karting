<?php

declare(strict_types=1);

namespace App\Http\ApiController\Request;

use Illuminate\Foundation\Http\FormRequest;

class TrackRequest extends FormRequest
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
            'slots' => 'required|integer|min:0',
            'enabled' => 'required|boolean',
            'price' => 'required|integer|min:0',
        ];
    }
}
