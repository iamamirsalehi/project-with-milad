<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Modules\Subscription\Models\Subscription;

class SubscriptionRepository extends EloquentBaseRepository implements ISubscriptionRepository
{
    public function save(Subscription $subscription): void
    {
        $subscription->save();
    }

    public function findByID(int $id): ?Subscription
    {
        return $this->model->newQuery()->where('id', $id)->first();
    }

    public function findByName(string $name): ?Subscription
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }

    public function exists(int $id): bool
    {
        return $this->model->newQuery()->where('id', $id)->exists();
    }
}
