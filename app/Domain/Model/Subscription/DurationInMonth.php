<?php

namespace App\Domain\Model\Subscription;

use App\Domain\Exceptions\MovieApplicationException;

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
