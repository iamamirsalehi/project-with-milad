<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Subscription\Models\UserSubscription;

class UserSubscriptionRepository extends EloquentBaseRepository implements IUserSubscriptionRepository
{
    public function save(UserSubscription $userSubscription): void
    {
        // TODO: Implement save() method.
    }

    public function exists(int $userID, int $subscriptionID): bool
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->where('subscription_id', $subscriptionID)
            ->exists();
    }

    public function findByUserID(int $userID): ?UserSubscription
    {
        return $this->model->newQuery()->where('user_id', $userID)->first();
    }
}
