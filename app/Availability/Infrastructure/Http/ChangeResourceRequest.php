<?php

declare(strict_types=1);


namespace App\Availability\Infrastructure\Http;

use Illuminate\Foundation\Http\FormRequest;

class ChangeResourceRequest extends FormRequest
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
            'is_available' => 'boolean|required',
        ];
    }
}
