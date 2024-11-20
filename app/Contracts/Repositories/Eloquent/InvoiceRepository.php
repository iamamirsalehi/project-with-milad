<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IInvoiceRepository;
use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Models\Invoice;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\InvoiceTypeID;
use App\Modules\User\Models\UserID;

class InvoiceRepository extends EloquentBaseRepository implements IInvoiceRepository
{
    public function save(Invoice $invoice): void
    {
        $invoice->save();
    }

    public function findByUserIDAndType(UserID $userID, InvoiceType $type, InvoiceTypeID $invoiceTypeID): ?Invoice
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->where('type', $type)
            ->where('type_id', $invoiceTypeID)
            ->first();
    }

    public function findByID(InvoiceID $invoiceID): ?Invoice
    {
        return $this->model->newQuery()
            ->where('id', $invoiceID)
            ->first();
    }
}
