<?php

namespace App\Contracts\Repositories;

use App\Modules\Payment\Models\InvoiceID;
use App\Modules\Payment\Models\Payment;
use App\Modules\User\Models\UserID;

interface IPaymentRepository
{
    public function findByUserID(UserID $userID): ?Payment;

    public function findByInvoiceID(InvoiceID $id): ?Payment;

    public function save(Payment $payment): void;
}
