<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Contracts\Repositories\IPaymentRepository;
use App\Modules\Payment\Events\PaidEvent;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Models\PaymentID;
use App\Modules\Payment\Services\PaymentProviders\PaymentRegistry;
use Illuminate\Contracts\Events\Dispatcher;

readonly class PaymentService
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
    public function pay(NewPayment $data): void
    {
        $payment = Payment::new(
            $data->getUserID(),
            $data->getAmount(),
            $data->getPaymentableType(),
            $data->getPaymentableID(),
            $data->getPaymentMethod(),
        );

        $this->paymentRepository->save($payment);

        $this->paymentRegistry->resolve($data->getPaymentMethod())->pay($data->getAmount());
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
