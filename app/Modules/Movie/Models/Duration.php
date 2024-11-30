<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

final readonly class Duration
{
    private const DAY_IN_HOURS = 24;

    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $hours)
    {
        if ($this->hours <= 0) {
            throw MovieApplicationException::invalidHours();
        }

        if(false === is_int($this->hours / self::DAY_IN_HOURS)){
            throw MovieApplicationException::invalidHours();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->hours;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
