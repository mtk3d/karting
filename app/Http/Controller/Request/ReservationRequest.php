<?php

declare(strict_types=1);

namespace App\Http\Controller\Request;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'karts_ids.*' => 'uuid',
            'track_id' => 'required|uuid',
            'from' => 'required|date',
            'to' => 'required|date'
        ];
    }
}
