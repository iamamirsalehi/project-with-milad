<?php

namespace App\Infrastructure\Persistance\Repository\Eloquent;

use App\Domain\Model\Subscription\Subscription;
use App\Domain\Model\Subscription\SubscriptionID;
use App\Domain\Repository\SubscriptionRepository;

class EloquentSubscriptionRepository extends EloquentBaseRepository implements SubscriptionRepository
{
    public function save(Subscription $subscription): void
    {
        $subscription->save();
    }

    public function findByID(SubscriptionID $id): ?Subscription
    {
        return $this->model->newQuery()->where('id', $id)->first();
    }

    public function findByName(string $name): ?Subscription
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }

    public function exists(SubscriptionID $id): bool
    {
        return $this->model->newQuery()->where('id', $id)->exists();
    }
}
