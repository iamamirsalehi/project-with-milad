<?php

namespace App\Http\Controllers\Requests\API\V1;

use App\Modules\Payment\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'invoice_id' => 'required|numeric',
            'method' => 'required|string|in:' . PaymentMethod::casesAsString() . '',
        ];
    }
}
