<?php

namespace App\Modules\Subscription\Services\UserSubscriptionService;

use App\Contracts\Repositories\ISubscriptionRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\InvoicePrice;
use App\Modules\Payment\Models\InvoiceTypeID;
use App\Modules\Payment\Services\InvoiceService\InvoiceService;
use App\Modules\Payment\Services\InvoiceService\NewInvoice;
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
        private InvoiceService              $invoiceService,
    )
    {
    }

    /**
     * @throws SubscriptionApplicationExceptions
     * @throws PaymentApplicationException
     */
    public function subscribe(UserID $userID, SubscriptionID $subscriptionID): InvoiceID
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

        $newInvoice = new NewInvoice(
            $userID,
            InvoiceType::Subscription,
            new InvoiceTypeID($userSubscription->id->toPrimitiveType()),
            new InvoicePrice($subscription->price->toPrimitiveType()),
        );

        return $this->invoiceService->add($newInvoice);
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
