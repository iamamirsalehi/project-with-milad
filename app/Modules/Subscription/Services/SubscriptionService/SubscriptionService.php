<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\Subscription;

readonly class SubscriptionService
{
    public function __construct(private ISubscriptionRepository $subscriptionRepository)
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function add(NewSubscription $data): void
    {
        $subscription = $this->subscriptionRepository->findByName($data->getName());
        if (false === is_null($subscription)) {
            throw SubscriptionApplicationExceptions::subscriptionAlreadyExists();
        }

        $subscription = Subscription::new(
            $data->getName(),
            $data->getPrice(),
            $data->getDurationInMonth()
        );

        $this->subscriptionRepository->save($subscription);
    }
}
