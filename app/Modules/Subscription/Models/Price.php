<?php

namespace App\Modules\Subscription\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class Price
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $price)
    {
        if ($this->price < 0) {
            throw MovieApplicationException::priceCanNotBeNegative();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->price;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
