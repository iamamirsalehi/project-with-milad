<?php

namespace App\Http\Controllers\Requests\API\V1;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'payment_id' => 'required|numeric|exists:payments,id',
        ];
    }
}
