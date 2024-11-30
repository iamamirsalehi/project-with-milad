<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

final readonly class DurationInMonth
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $month)
    {
        if ($this->month < 0) {
            throw MovieApplicationException::durationInMonthCanNotBeNegative();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->month;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
