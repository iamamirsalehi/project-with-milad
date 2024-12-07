<?php

namespace App\Src\Domain\Enums;

enum PaymentStatus: string
{
    case Paid = 'paid';
    case Unpaid = 'unpaid';
}
