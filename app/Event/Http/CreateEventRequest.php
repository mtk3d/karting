<?php

declare(strict_types=1);


namespace App\Event\Http;

use Illuminate\Foundation\Http\FormRequest;

class CreateEventRequest extends FormRequest
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
            'start_date' => 'required|date',
            'end_date' => 'date',
            'days' => 'array',
            'days.*' => 'in:monday,tuesday,wednesday,thursday,friday,saturday,sunday'
        ];
    }
}
