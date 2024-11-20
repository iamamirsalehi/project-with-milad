<?php

namespace App\Modules\Payment\Services\PaymentService;

use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Models\InvoiceID;

readonly class NewPayment
{
    public function __construct(
        private InvoiceID     $invoiceID,
        private PaymentMethod $paymentMethod,
    )
    {
    }

    public function getInvoiceID(): InvoiceID
    {
        return $this->invoiceID;
    }

    public function getPaymentMethod(): PaymentMethod
    {
        return $this->paymentMethod;
    }
}
