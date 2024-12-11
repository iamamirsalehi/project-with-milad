<?php

namespace App\Application\Command;

use App\Domain\Model\Subscription\SubscriptionID;
use App\Domain\Model\User\UserID;

final readonly class SubscribeCommand
{
    public function __construct(
        public UserID         $userID,
        public SubscriptionID $subscriptionID
    )
    {
    }
}
