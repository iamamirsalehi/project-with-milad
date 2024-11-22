<?php

namespace App\Modules\Payment\Listeners;

use App\Modules\Payment\Events\PaidEvent;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\Subscription;
use App\Modules\Subscription\Models\SubscriptionID;
use App\Modules\Subscription\Services\UserSubscriptionService\UserSubscriptionService;
use Illuminate\Contracts\Queue\ShouldQueue;

readonly class ActivateSubscription implements ShouldQueue
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
