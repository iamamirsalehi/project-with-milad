<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Amount;
use App\Modules\Payment\Models\PaymentableID;
use App\Modules\Payment\Models\PaymentableType;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;

readonly class SubscriptionPayService
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
    public function pay(NewSubscriptionPayment $data): void
    {
        $subscription = $this->subscriptionRepository->findByID($data->getSubscriptionID());
        if (is_null($subscription)) {
            throw SubscriptionApplicationExceptions::invalidSubscriptionID();
        }

        $newPayment = new NewPayment(
            $data->getUserID(),
            new Amount($subscription->price->toPrimitiveType()),
            $data->getPaymentMethod(),
            new PaymentableType($subscription),
            new PaymentableID($subscription->id->toPrimitiveType()),
        );

        $this->paymentService->pay($newPayment);
    }
}
