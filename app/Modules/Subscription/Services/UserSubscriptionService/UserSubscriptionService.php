<?php

namespace App\Modules\Subscription\Services\UserSubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\ExpiresAt;
use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\User\Models\UserID;
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
