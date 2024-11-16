<?php

namespace App\Contracts\Repositories;

use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\Subscription\Models\UserSubscription;
use App\Modules\User\Models\UserID;

interface IUserSubscriptionRepository
{
    public function save(UserSubscription $userSubscription): void;

    public function exists(UserID $userID, SubscriptionID $subscriptionID): bool;

    public function findByUserID(UserID $userID): ?UserSubscription;
}
