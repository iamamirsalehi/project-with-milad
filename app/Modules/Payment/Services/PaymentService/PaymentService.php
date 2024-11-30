<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Contracts\Repositories\IPaymentRepository;
use App\Modules\Payment\Events\PaidEvent;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Models\PaymentID;
use App\Modules\Payment\Services\PaymentProviders\PaymentRegistry;
use Illuminate\Contracts\Events\Dispatcher;

final readonly class PaymentService
{
    public function __construct(
        private IPaymentRepository $paymentRepository,
        private PaymentRegistry    $paymentRegistry,
        private Dispatcher         $dispatcher,
    )
    {
    }

    /**
     * @throws PaymentApplicationException
     */
    public function pay(NewPayment $newPayment): void
    {
        $payment = Payment::new(
            $newPayment->getUserID(),
            $newPayment->getAmount(),
            $newPayment->getPaymentableType(),
            $newPayment->getPaymentableID(),
            $newPayment->getPaymentMethod(),
        );

        $this->paymentRepository->save($payment);

        $this->paymentRegistry->resolve($newPayment->getPaymentMethod())->pay($newPayment->getAmount());
    }

    /**
     * @throws PaymentApplicationException
     */
    public function verify(PaymentID $paymentID): void
    {
        $payment = $this->paymentRepository->findByID($paymentID);
        if (is_null($payment)) {
            throw PaymentApplicationException::invalidPaymentID();
        }

        $payment->pay();

        $this->paymentRepository->save($payment);

        $this->dispatcher->dispatch(new PaidEvent($payment));
    }
}
