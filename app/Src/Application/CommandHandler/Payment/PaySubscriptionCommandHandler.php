<?php

namespace App\Src\Application\CommandHandler\Payment;

use App\Src\Application\Command\Payment\PaySubscriptionCommand;
use App\Src\Application\Service\PaymentService\NewPayment;
use App\Src\Application\Service\PaymentService\PaymentService;
use App\Src\Domain\Exceptions\PaymentApplicationException;
use App\Src\Domain\Exceptions\SubscriptionApplicationExceptions;
use App\Src\Domain\Model\Payment\Amount;
use App\Src\Domain\Model\Payment\PaymentableID;
use App\Src\Domain\Model\Payment\PaymentableType;
use App\Src\Domain\Repository\ISubscriptionRepository;

final readonly class PaySubscriptionCommandHandler
{
    public function __construct(
        private ISubscriptionRepository $subscriptionRepository,
        private PaymentService          $paymentService,
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
