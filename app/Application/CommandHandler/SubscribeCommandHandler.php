<?php

namespace App\Application\CommandHandler;

use App\Application\Command\SubscribeCommand;
use App\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Domain\Model\Subscription\ExpiresAt;
use App\Domain\Model\User\UserID;
use App\Domain\Repository\SubscriptionRepository;
use App\Domain\Repository\UserSubscriptionRepository;
use Illuminate\Support\Carbon;

final readonly class SubscribeCommandHandler
{
    public function __construct(
        private SubscriptionRepository     $subscriptionRepository,
        private UserSubscriptionRepository $userSubscriptionRepository
    )
    {

    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function __invoke(SubscribeCommand $subscribeCommand): void
    {
        $subscription = $this->subscriptionRepository->findByID($subscribeCommand->subscriptionID);
        if (is_null($subscription)) {
            throw SubscriptionApplicationExceptions::couldNotFindSubscription();
        }

        if ($this->hasActiveSubscription($subscribeCommand->userID)) {
            throw SubscriptionApplicationExceptions::userCanNotHaveTwoSubscriptions();
        }

        $expiresAt = new ExpiresAt(Carbon::now()->addMonths($subscription->duration_in_month->toPrimitiveType()));

        $userSubscription = $subscription->subscribe($subscribeCommand->userID, $expiresAt);

        $userSubscription->activate();

        $this->userSubscriptionRepository->save($userSubscription);
    }

    private function hasActiveSubscription(UserID $userID): bool
    {
        $userSubscription = $this->userSubscriptionRepository->findByUserID($userID);
        if (is_null($userSubscription)) {
            return false;
        }

        return $userSubscription->isActive();
    }
}
