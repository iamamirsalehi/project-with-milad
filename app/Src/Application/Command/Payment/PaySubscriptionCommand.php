<?php

namespace App\Src\Application\Command\Payment;

use App\Src\Domain\Model\Subscription\SubscriptionID;
use App\Src\Domain\Model\User\UserID;

final readonly class PaySubscriptionCommand
{
    public function __construct(
        public UserID         $userID,
        public SubscriptionID $subscriptionID,
        public string         $paymentMethod,
    )
    {
    }
}
