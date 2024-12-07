<?php

namespace App\Src\Instrastructure\Persistance\Repository\Eloquent;

use App\Src\Domain\Model\Subscription\Subscription;
use App\Src\Domain\Model\Subscription\SubscriptionID;
use App\Src\Domain\Repository\ISubscriptionRepository;

class SubscriptionRepository extends EloquentBaseRepository implements ISubscriptionRepository
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
