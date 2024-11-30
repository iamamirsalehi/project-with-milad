<?php

namespace App\Modules\Payment\Models;

use App\Modules\Movie\Models\MovieRent;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Subscription\Models\Subscription;
use Illuminate\Database\Eloquent\Model;

final class PaymentableType
{
    /**
     * @throws PaymentApplicationException
     */
    public function __construct(private Model $paymentable)
    {
        if (
            !$this->paymentable instanceof Subscription
            && !$this->paymentable instanceof MovieRent
        ) {
            throw PaymentApplicationException::invalidPaymentableType();
        }
    }

    public function toPrimitiveType(): Model
    {
        return $this->paymentable;
    }

    public function __tostring(): string
    {
        return $this->paymentable->getMorphClass();
    }
}
