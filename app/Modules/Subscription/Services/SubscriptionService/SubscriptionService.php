<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\Subscription;

final readonly class SubscriptionService
{
    public function __construct(private ISubscriptionRepository $subscriptionRepository)
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function add(NewSubscription $newSubscription): void
    {
        $subscription = $this->subscriptionRepository->findByName($newSubscription->getName());
        if (false === is_null($subscription)) {
            throw SubscriptionApplicationExceptions::subscriptionAlreadyExists();
        }

        $subscription = Subscription::new(
            $newSubscription->getName(),
            $newSubscription->getPrice(),
            $newSubscription->getDurationInMonth()
        );

        $this->subscriptionRepository->save($subscription);
    }
}
