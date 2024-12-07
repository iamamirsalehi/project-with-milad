<?php

namespace App\Src\UI\Request\API;

use App\Modules\Payment\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class PaySubscriptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|string|exists:users,id',
            'subscription_id' => 'required|string|exists:subscriptions,id',
            'method' => 'required|string',
        ];
    }
}
