<?php

namespace App\Domain\Events;

use App\Domain\Model\Payment\Payment;
use Illuminate\Foundation\Events\Dispatchable;

final readonly class PaidEvent
{
    use Dispatchable;

    public function __construct(public Payment $payment)
    {
    }
}
