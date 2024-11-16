<?php

namespace App\Contracts\Repositories;

use App\Modules\Subscription\Models\Subscription;
use App\Modules\Subscription\Models\SubscriptionID;

interface ISubscriptionRepository
{
    public function save(Subscription $subscription): void;

    public function exists(SubscriptionID $id): bool;

    public function findByName(string $name): ?Subscription;

    public function findByID(SubscriptionID $id): ?Subscription;
}
