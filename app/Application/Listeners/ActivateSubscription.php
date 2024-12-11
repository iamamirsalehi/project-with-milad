<?php

namespace App\Application\Listeners;

use App\Application\Command\SubscribeCommand;
use App\Domain\Events\PaidEvent;
use App\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Domain\Model\Subscription\Subscription;
use App\Domain\Model\Subscription\SubscriptionID;
use App\Infrastructure\CommandBus\CommandBus;
use Illuminate\Contracts\Queue\ShouldQueue;

final readonly class ActivateSubscription implements ShouldQueue
{
    public function __construct(
        private CommandBus $commandBus
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

        $this->commandBus->handle(
            new SubscribeCommand($payment->user_id, new SubscriptionID($payment->paymentable_id->toPrimitiveType()))
        );
    }
}
