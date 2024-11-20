<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Contracts\Repositories\IInvoiceRepository;
use App\Contracts\Repositories\IMovieRentRepository;
use App\Contracts\Repositories\IPaymentRepository;
use App\Contracts\Repositories\IUserSubscriptionRepository;
use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\MovieRentID;
use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Amount;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethodFactory;
use App\Modules\Payment\Services\PaymentProviders\PaymentProvider;
use App\Modules\Subscription\Exceptions\SubscriptionApplicationExceptions;
use App\Modules\Subscription\Models\UserSubscriptionID;
use Illuminate\Contracts\Events\Dispatcher;

readonly class PaymentService
{
    public function __construct(
        private IInvoiceRepository          $invoiceRepository,
        private IPaymentRepository          $paymentRepository,
        private IUserSubscriptionRepository $userSubscriptionRepository,
        private IMovieRentRepository        $movieRentRepository,
        private PaymentProvider             $paymentProvider,
        private PaymentMethodFactory        $paymentMethodFactory,
        private Dispatcher                  $dispatcher,
    )
    {
    }

    /**
     * @throws PaymentApplicationException
     */
    public function pay(NewPayment $data): void
    {
        $invoice = $this->invoiceRepository->findByID($data->getInvoiceID());
        if (is_null($invoice)) {
            throw PaymentApplicationException::invoiceDoesNotExist();
        }

        if ($invoice->isPaid()) {
            throw PaymentApplicationException::invoiceIsAlreadyPaid();
        }

        $payment = Payment::new($invoice->user_id, $data->getInvoiceID(), $data->getPaymentMethod());

        $this->paymentRepository->save($payment);

        $paymentMethod = $this->paymentMethodFactory->getFrom($data->getPaymentMethod());

        $this->paymentProvider->setPaymentMethod($paymentMethod);

        $this->paymentProvider->pay(new Amount($invoice->price->toPrimitiveType()));
    }

    /**
     * @throws PaymentApplicationException
     * @throws SubscriptionApplicationExceptions
     * @throws MovieApplicationException
     */
    public function verify(InvoiceID $invoiceID): void
    {
        $invoice = $this->invoiceRepository->findByID($invoiceID);
        if (is_null($invoice)) {
            throw PaymentApplicationException::invoiceDoesNotExist();
        }

        $payment = $this->paymentRepository->findByInvoiceID($invoiceID);
        if (is_null($payment)) {
            throw PaymentApplicationException::invoiceDoesNotExist();
        }

        $paymentMethod = $this->paymentMethodFactory->getFrom($payment->method);

        $this->paymentProvider->setPaymentMethod($paymentMethod);

        $this->paymentProvider->verify();

        if ($invoice->type == InvoiceType::Subscription) {
            $userSubscription = $this->userSubscriptionRepository->findByID(new UserSubscriptionID($invoiceID->toPrimitiveType()));
            if (is_null($userSubscription)) {
                throw SubscriptionApplicationExceptions::userDoesNotHaveSubscription();
            }

            $userSubscription->active();

            $this->userSubscriptionRepository->save($userSubscription);

            $payment->pay();
            $invoice->pay();

            $this->dispatcher->dispatch();
            return;
        }

        $moveRent = $this->movieRentRepository->findByID(new MovieRentID($invoiceID->toPrimitiveType()));
        if (is_null($moveRent)) {
            throw MovieApplicationException::movieRentDoesNotExist();
        }

        $moveRent->pay();
        $invoice->pay();
    }
}
