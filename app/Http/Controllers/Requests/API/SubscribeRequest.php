<?php

namespace App\Http\Controllers\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|numeric',
            'subscription_id' => 'required|numeric|exists:subscriptions,id',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
