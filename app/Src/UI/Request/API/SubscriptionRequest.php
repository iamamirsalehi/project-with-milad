<?php

namespace App\Src\UI\Request\API;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'duration_in_month' => 'required|numeric',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
