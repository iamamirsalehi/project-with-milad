<?php

namespace App\Application\CommandHandler;

use App\Application\Command\AddSubscriptionCommand;
use App\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Domain\Model\Subscription\Subscription;
use App\Domain\Repository\SubscriptionRepository;

final readonly class AddSubscriptionCommandHandler
{
    public function __construct(private SubscriptionRepository $subscriptionRepository)
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function __invoke(AddSubscriptionCommand $addSubscriptionCommand): void
    {
        $subscription = $this->subscriptionRepository->findByName($addSubscriptionCommand->name);
        if (false === is_null($subscription)) {
            throw SubscriptionApplicationExceptions::subscriptionAlreadyExists();
        }

        $subscription = Subscription::new(
            $addSubscriptionCommand->name,
            $addSubscriptionCommand->price,
            $addSubscriptionCommand->durationInMonth
        );

        $this->subscriptionRepository->save($subscription);
    }
}
