<?php

namespace App\Src\Application\CommandHandler\Subscription;

use App\Src\Application\Command\Subscription\AddSubscriptionCommand;
use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\Subscription\Subscription;
use App\Src\Domain\Repository\ISubscriptionRepository;

final readonly class AddSubscriptionCommandHandler
{
    public function __construct(private ISubscriptionRepository $subscriptionRepository)
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
