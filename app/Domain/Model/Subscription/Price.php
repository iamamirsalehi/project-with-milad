<?php

namespace App\Domain\Model\Subscription;

use App\Domain\Exceptions\MovieApplicationException;

final readonly class Price
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
