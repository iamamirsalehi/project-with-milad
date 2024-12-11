<?php

namespace App\Domain\Repository;

use App\Domain\Model\Subscription\SubscriptionID;
use App\Domain\Model\Subscription\UserSubscription;
use App\Domain\Model\Subscription\UserSubscriptionID;
use App\Domain\Model\User\UserID;

interface UserSubscriptionRepository
{
    public function save(UserSubscription $userSubscription): void;

    public function exists(UserID $userID, SubscriptionID $subscriptionID): bool;

    public function findByUserID(UserID $userID): ?UserSubscription;

    public function findLatestByUserID(UserID $userID): ?UserSubscription;

    public function findByID(UserSubscriptionID $id): ?UserSubscription;
}
