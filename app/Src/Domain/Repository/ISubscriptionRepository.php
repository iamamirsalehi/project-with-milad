<?php

namespace App\Src\Domain\Repository;

use App\Src\Domain\Model\Subscription\Subscription;
use App\Src\Domain\Model\Subscription\SubscriptionID;

interface ISubscriptionRepository
{
    public function save(Subscription $subscription): void;

    public function exists(SubscriptionID $id): bool;

    public function findByName(string $name): ?Subscription;

    public function findByID(SubscriptionID $id): ?Subscription;
}
