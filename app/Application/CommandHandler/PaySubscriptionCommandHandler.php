<?php

namespace App\Application\CommandHandler;

use App\Application\Command\PaySubscriptionCommand;
use App\Application\Service\PaymentService\NewPayment;
use App\Application\Service\PaymentService\PaymentService;
use App\Domain\Exceptions\PaymentApplicationException;
use App\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Domain\Model\Payment\Amount;
use App\Domain\Model\Payment\PaymentableID;
use App\Domain\Model\Payment\PaymentableType;
use App\Domain\Repository\SubscriptionRepository;

final readonly class PaySubscriptionCommandHandler
{
    public function __construct(
        private SubscriptionRepository $subscriptionRepository,
        private PaymentService         $paymentService,
    )
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     * @throws PaymentApplicationException
     */
    public function __invoke(PaySubscriptionCommand $paySubscriptionCommand): void
    {
        $subscription = $this->subscriptionRepository->findByID($paySubscriptionCommand->subscriptionID);
        if (is_null($subscription)) {
            throw SubscriptionApplicationExceptions::invalidSubscriptionID();
        }

        $newPayment = new NewPayment(
            $paySubscriptionCommand->userID,
            new Amount($subscription->price->toPrimitiveType()),
            $paySubscriptionCommand->paymentMethod,
            new PaymentableType($subscription),
            new PaymentableID($subscription->id->toPrimitiveType()),
        );

        $this->paymentService->pay($newPayment);
    }
}
