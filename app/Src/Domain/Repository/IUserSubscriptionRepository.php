<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Subscription\SubscriptionID;
use App\Src\Domain\Model\Subscription\UserSubscription;
use App\Src\Domain\Model\Subscription\UserSubscriptionID;
use App\Src\Domain\Model\User\UserID;

interface IUserSubscriptionRepository
{
    public function save(UserSubscription $userSubscription): void;

    public function exists(UserID $userID, SubscriptionID $subscriptionID): bool;

    public function findByUserID(UserID $userID): ?UserSubscription;

    public function findLatestByUserID(UserID $userID): ?UserSubscription;

    public function findByID(UserSubscriptionID $id): ?UserSubscription;
}
