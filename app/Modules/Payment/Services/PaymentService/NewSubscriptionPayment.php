<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\User\Models\UserID;

final readonly class NewSubscriptionPayment
{
    public function __construct(
        private UserID $userID,
        private SubscriptionID $subscriptionID,
        private string $paymentMethod,
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

    public function getPaymentMethod(): string
    {
        return $this->paymentMethod;
    }
}
