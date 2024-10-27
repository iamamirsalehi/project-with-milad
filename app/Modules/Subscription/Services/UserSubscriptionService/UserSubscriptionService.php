<?php

namespace App\Modules\Subscription\Services\UserSubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\UserSubscription;
use Illuminate\Support\Carbon;

readonly class UserSubscriptionService
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
    public function subscribe(int $userID, int $subscriptionID): void
    {
        $subscription = $this->subscriptionRepository->findByID($subscriptionID);
        if (is_null($subscription)) {
            throw SubscriptionApplicationExceptions::couldNotFindSubscription();
        }

        if ($this->hasActiveSubscription($userID)) {
            throw SubscriptionApplicationExceptions::userCanNotHaveTwoSubscriptions();
        }

        $userSubscription = new UserSubscription();
        $userSubscription->subscribe($userID, $subscriptionID, Carbon::now()->addMonths($subscription->duration_in_month));

        $this->userSubscriptionRepository->save($userSubscription);
    }

    private function hasActiveSubscription(int $userID): bool
    {
        $userSubscription = $this->userSubscriptionRepository->findByUserID($userID);
        if (is_null($userSubscription)) {
            return false;
        }

        return $userSubscription->isActive();
    }
}
