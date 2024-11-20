<?php

namespace App\Modules\Movie\Enums;

enum MovieRentStatus: string
{
    case Paid = 'paid';
    case Unpaid = 'unpaid';
}
