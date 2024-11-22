<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Contracts\Repositories\IPaymentRepository;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Payment;
use App\Modules\Payment\Services\PaymentProviders\PaymentMethodFactory;
use Illuminate\Contracts\Events\Dispatcher;

readonly class PaymentService
{
    public function __construct(
        private IPaymentRepository   $paymentRepository,
        private PaymentMethodFactory $paymentMethodFactory,
        private Dispatcher           $dispatcher,
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

        $paymentMethod = $this->paymentMethodFactory->getFrom($data->getPaymentMethod());
    }

    public function verify(InvoiceID $invoiceID): void
    {

    }
}
