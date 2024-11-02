<?php

namespace App\Modules\Subscription\Services\SubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\Subscription;

readonly class SubscriptionService
{
    public function __construct(private ISubscriptionRepository $subscriptionRepository)
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     * @throws MovieApplicationException
     */
    public function add(SubscriptionData $data): void
    {
        if (false === is_null($this->subscriptionRepository->findByName($data->getName()))) {
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
