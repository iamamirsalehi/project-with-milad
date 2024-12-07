<?php

namespace App\Src\Domain\Enums;

enum UserSubscriptionStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
