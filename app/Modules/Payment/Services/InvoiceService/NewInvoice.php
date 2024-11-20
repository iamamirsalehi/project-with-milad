<?php

namespace App\Modules\Payment\Services\InvoiceService;

use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Models\InvoicePrice;
use App\Modules\Payment\Models\InvoiceTypeID;
use App\Modules\User\Models\UserID;

readonly class NewInvoice
{
    public function __construct(
        private UserID        $userID,
        private InvoiceType   $invoiceType,
        private InvoiceTypeID $invoiceTypeID,
        private InvoicePrice  $invoicePrice,
    )
    {
    }

    public function getUserID(): UserID
    {
        return $this->userID;
    }

    public function getInvoiceType(): InvoiceType
    {
        return $this->invoiceType;
    }

    public function getInvoiceTypeID(): InvoiceTypeID
    {
        return $this->invoiceTypeID;
    }

    public function getInvoicePrice(): InvoicePrice
    {
        return $this->invoicePrice;
    }
}
