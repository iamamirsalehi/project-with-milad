<?php

namespace App\Modules\Payment\Models;

use App\Modules\Payment\Enums\InvoiceStatus;
use App\Modules\Payment\Enums\InvoiceType;
use App\Modules\Payment\Exceptions\PaymentApplicationException;
use App\Modules\Payment\Models\Casts\InvoiceIDCast;
use App\Modules\Payment\Models\Casts\InvoicePriceCast;
use App\Modules\Payment\Models\Casts\InvoiceTypeIDCast;
use App\Modules\User\Models\Casts\UserIDCast;
use App\Modules\User\Models\UserID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read InvoiceID $id
 * @property-read UserID $user_id
 * @property-read InvoiceType $type
 * @property-read InvoiceTypeID $type_id
 * @property-read InvoicePrice $price
 * @property-read InvoiceStatus $status
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class Invoice extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => InvoiceIDCast::class,
            'user_id' => UserIDCast::class,
            'type' => InvoiceType::class,
            'type_id' => InvoiceTypeIDCast::class,
            'price' => InvoicePriceCast::class,
            'status' => InvoiceStatus::class,
        ];
    }

    public static function new(
        UserID        $userID,
        InvoiceType   $type,
        InvoiceTypeID $typeID,
        InvoicePrice  $price,
    ): self
    {
        $invoice = new self();

        $invoice->user_id = $userID;
        $invoice->type = $type;
        $invoice->type_id = $typeID;
        $invoice->price = $price;
        $invoice->status = InvoiceStatus::Unpaid;

        return $invoice;
    }

    public function isPaid(): bool
    {
        return $this->status === InvoiceStatus::Paid;
    }

    public function pay(): void
    {
        if ($this->status == InvoiceStatus::Paid) {
            throw PaymentApplicationException::invoiceIsAlreadyPaid();
        }

        $this->status = InvoiceStatus::Paid;
    }
}
