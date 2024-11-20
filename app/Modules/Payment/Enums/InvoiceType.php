<?php

namespace App\Modules\Payment\Enums;

enum InvoiceType: string
{
    case Rent = 'rent';
    case Subscription = 'subscription';
}