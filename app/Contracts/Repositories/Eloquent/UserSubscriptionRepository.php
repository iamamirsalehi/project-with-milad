<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\Subscription\Models\UserSubscription;
use App\Modules\User\Models\UserID;

class UserSubscriptionRepository extends EloquentBaseRepository implements IUserSubscriptionRepository
{
    public function save(UserSubscription $userSubscription): void
    {
        $userSubscription->save();
    }

    public function exists(UserID $userID, SubscriptionID $subscriptionID): bool
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->where('subscription_id', $subscriptionID)
            ->exists();
    }

    public function findByUserID(UserID $userID): ?UserSubscription
    {
        return $this->model->newQuery()->where('user_id', $userID)->first();
    }
}
