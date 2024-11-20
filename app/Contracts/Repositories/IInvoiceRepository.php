<?php

namespace App\Contracts\Repositories;

use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Models\Invoice;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\InvoiceTypeID;
use App\Modules\User\Models\UserID;

interface IInvoiceRepository
{
    public function findByID(InvoiceID $invoiceID): ?Invoice;

    public function findByUserIDAndType(UserID $userID, InvoiceType $type, InvoiceTypeID $invoiceTypeID): ?Invoice;

    public function save(Invoice $invoice): void;
}
