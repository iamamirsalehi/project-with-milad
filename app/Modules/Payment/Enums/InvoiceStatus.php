<?php

namespace App\Modules\Payment\Enums;

enum InvoiceStatus: string
{
    case Paid = 'paid';
    case Unpaid = 'unpaid';
}
