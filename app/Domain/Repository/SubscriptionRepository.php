<?php

namespace App\Domain\Repository;

use App\Domain\Model\Subscription\Subscription;
use App\Domain\Model\Subscription\SubscriptionID;

interface SubscriptionRepository
{
    public function save(Subscription $subscription): void;

    public function exists(SubscriptionID $id): bool;

    public function findByName(string $name): ?Subscription;

    public function findByID(SubscriptionID $id): ?Subscription;
}
