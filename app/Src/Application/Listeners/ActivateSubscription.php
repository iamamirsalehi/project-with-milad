<?php

namespace App\Src\Application\Listeners;

use App\Src\Application\Events\PaidEvent;
use App\Src\Application\Service\UserSubscriptionService\UserSubscriptionService;
use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\Subscription\Subscription;
use App\Src\Domain\Model\Subscription\SubscriptionID;
use Illuminate\Contracts\Queue\ShouldQueue;

final readonly class ActivateSubscription implements ShouldQueue
{
    public function __construct(
        private UserSubscriptionService $userSubscriptionService
    )
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     */
    public function handle(PaidEvent $paidEvent): void
    {
        $payment = $paidEvent->payment;

        if ($payment->paymentable_type->toPrimitiveType() != (new Subscription())->getMorphClass()) {
            return;
        }

        $this->userSubscriptionService->subscribe($payment->user_id, new SubscriptionID($payment->paymentable_id->toPrimitiveType()));
    }
}
