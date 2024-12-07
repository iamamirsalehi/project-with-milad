<?php

namespace App\Src\Application\Service\UserSubscriptionService;

use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\Subscription\ExpiresAt;
use App\Src\Domain\Model\Subscription\SubscriptionID;
use App\Src\Domain\Model\User\UserID;
use App\Src\Domain\Repository\ISubscriptionRepository;
use App\Src\Domain\Repository\IUserSubscriptionRepository;
use Illuminate\Support\Carbon;

final readonly class UserSubscriptionService
{
    public function __construct(
        private IUserSubscriptionRepository $userSubscriptionRepository,
        private ISubscriptionRepository     $subscriptionRepository,
    )
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function subscribe(UserID $userID, SubscriptionID $subscriptionID): void
    {
        $subscription = $this->subscriptionRepository->findByID($subscriptionID);
        if (is_null($subscription)) {
            throw SubscriptionApplicationExceptions::couldNotFindSubscription();
        }

        if ($this->hasActiveSubscription($userID)) {
            throw SubscriptionApplicationExceptions::userCanNotHaveTwoSubscriptions();
        }

        $expiresAt = new ExpiresAt(Carbon::now()->addMonths($subscription->duration_in_month->toPrimitiveType()));

        $userSubscription = $subscription->subscribe($userID, $expiresAt);

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
