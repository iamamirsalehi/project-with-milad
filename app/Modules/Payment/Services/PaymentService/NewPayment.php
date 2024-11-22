<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Models\Amount;
use App\Modules\Payment\Models\PaymentableID;
use App\Modules\Payment\Models\PaymentableType;
use App\Modules\User\Models\UserID;

readonly class NewPayment
{
    public function __construct(
        private UserID          $userID,
        private Amount          $amount,
        private PaymentMethod   $paymentMethod,
        private PaymentableType $paymentableType,
        private PaymentableID   $paymentableID,
    )
    {
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getPaymentableType(): PaymentableType
    {
        return $this->paymentableType;
    }

    public function getPaymentableID(): PaymentableID
    {
        return $this->paymentableID;
    }
}
