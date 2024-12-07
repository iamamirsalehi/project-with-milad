<?php

namespace App\Src\Application\Events;

use App\Src\Domain\Model\Payment\Payment;
use Illuminate\Foundation\Events\Dispatchable;

final class PaidEvent
{
    use Dispatchable;

    public function __construct(public readonly Payment $payment)
    {
    }
}
