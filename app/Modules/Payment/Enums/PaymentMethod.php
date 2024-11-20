<?php

namespace App\Modules\Payment\Enums;

enum PaymentMethod: string
{
    case Mellat = 'mellat';
    case Saman = 'saman';

    public static function casesAsString(): string
    {
        $casesAsString = '';
        foreach (self::cases() as $case) {
            $casesAsString .= sprintf("%s,", $case->value);
        }

        return $casesAsString;
    }
}
