<?php

namespace App\Contracts\Repositories;

use App\Modules\Subscription\Models\Subscription;

interface ISubscriptionRepository
{
    public function save(Subscription $subscription): void;

    public function exists(int $id): bool;

    public function findByName(string $name): ?Subscription;

    public function findByID(int $id): ?Subscription;
}
