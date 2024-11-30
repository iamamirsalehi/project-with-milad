<?php

namespace App\Modules\Payment\Events;

use App\Modules\Payment\Models\Payment;
use Illuminate\Foundation\Events\Dispatchable;

final class PaidEvent
{
    use Dispatchable;

    public function __construct(public readonly Payment $payment)
    {
    }
}
