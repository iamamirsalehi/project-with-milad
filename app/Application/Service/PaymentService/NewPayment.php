<?php

namespace App\Application\Service\PaymentService;

use App\Domain\Model\Payment\Amount;
use App\Domain\Model\Payment\PaymentableID;
use App\Domain\Model\Payment\PaymentableType;
use App\Domain\Model\User\UserID;

final readonly class NewPayment
{
    public function __construct(
        private UserID          $userID,
        private Amount          $amount,
        private string   $paymentMethod,
        private PaymentableType $paymentableType,
        private PaymentableID   $paymentableID,
    )
    {
    }

    public function getPaymentMethod(): string
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
