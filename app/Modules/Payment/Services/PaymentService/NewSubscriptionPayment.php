<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\User\Models\UserID;

readonly class NewSubscriptionPayment
{
    public function __construct(
        private UserID $userID,
        private SubscriptionID $subscriptionID,
        private PaymentMethod $paymentMethod,
    )
    {
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }

    public function getSubscriptionID(): SubscriptionID
    {
        return $this->subscriptionID;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }
}
