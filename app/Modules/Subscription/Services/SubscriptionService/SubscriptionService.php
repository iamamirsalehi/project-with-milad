<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Modules\Subscription\Models\Subscription;

class SubscriptionService
{
    public function __construct(private ISubscriptionRepository $subscriptionRepository)
    {
    }

    public function add(SubscriptionData $data): void
    {
        //TODO: What fields to be considered unique?

        $subscription = Subscription::new(
            $data->getName(),
            $data->getPrice(),
            $data->getDurationInMonth()
        );

        $this->subscriptionRepository->save($subscription);
    }
}
