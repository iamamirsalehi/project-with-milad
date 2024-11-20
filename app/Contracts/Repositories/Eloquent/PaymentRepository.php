<?php

namespace App\Contracts\Repositories\Eloquent;

use App\Contracts\Repositories\IPaymentRepository;
use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\Payment;
use App\Modules\User\Models\UserID;

class PaymentRepository extends EloquentBaseRepository implements IPaymentRepository
{
    public function findByUserID(UserID $userID): ?Payment
    {
        return $this->model->newQuery()
            ->where('user_id', $userID)
            ->first();
    }

    public function save(Payment $payment): void
    {
        $payment->save();
    }

    public function findByInvoiceID(InvoiceID $id): ?Payment
    {
        return $this->model->newQuery()
            ->where('invoice_id', $id)
            ->first();
    }
}
