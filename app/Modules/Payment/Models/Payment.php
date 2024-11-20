<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Enums\PaymentMethod;
use App\Modules\Payment\Enums\PaymentStatus;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Casts\InvoiceIDCast;
use App\Modules\Payment\Models\Casts\PaymentIDCast;
use App\Modules\User\Models\Casts\UserIDCast;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read PaymentID $id
 * @property-read UserID $user_id
 * @property-read InvoiceID $invoice_id
 * @property-read PaymentStatus $status
 * @property-read PaymentMethod $method
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
class Payment extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => PaymentIDCast::class,
            'user_id' => UserIDCast::class,
            'invoice_id' => InvoiceIDCast::class,
            'status' => PaymentStatus::class,
            'method' => PaymentMethod::class,
        ];
    }

    public static function new(
        UserID        $userID,
        InvoiceID     $invoiceID,
        PaymentMethod $method
    ): self
    {
        $payment = new self();

        $payment->user_id = $userID;
        $payment->invoice_id = $invoiceID;
        $payment->status = PaymentStatus::Unpaid;
        $payment->method = $method;

        return $payment;
    }

    /**
     * @throws PaymentApplicationException
     */
    public function pay(): void
    {
        if ($this->status === PaymentStatus::Paid) {
            throw PaymentApplicationException::paymentStatusIsAlreadyPaid();
        }

        $this->status = PaymentStatus::Paid;
    }
}
