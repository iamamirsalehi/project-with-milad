<?php

namespace App\UI\Request\API;

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
