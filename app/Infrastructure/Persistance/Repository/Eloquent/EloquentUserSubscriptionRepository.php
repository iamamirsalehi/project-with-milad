<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\Subscription\SubscriptionID;
use App\Domain\Model\Subscription\UserSubscription;
use App\Domain\Model\Subscription\UserSubscriptionID;
use App\Domain\Model\User\UserID;
use App\Domain\Repository\UserSubscriptionRepository;

class EloquentUserSubscriptionRepository extends EloquentBaseRepository implements UserSubscriptionRepository
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

    public function findLatestByUserID(UserID $userID): ?UserSubscription
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->orderByDesc('id')
            ->first();
    }

    public function findByID(UserSubscriptionID $id): ?UserSubscription
    {
        return $this->model->newQuery()
            ->where('id', $id)
            ->first();
    }
}
