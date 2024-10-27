<?php

namespace App\Contracts\Repositories;

use App\Modules\Subscription\Models\UserSubscription;

interface IUserSubscriptionRepository
{
    public function save(UserSubscription $userSubscription): void;

    public function exists(int $userID, int $subscriptionID): bool;

    public function findByUserID(int $userID): ?UserSubscription;
}
