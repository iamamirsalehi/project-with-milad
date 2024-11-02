<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class Price
{
    public function __construct(private int $price)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(): int
    {
        $this->validate();

        return $this->price;
    }

    /**
     * @throws MovieApplicationException
     */
    private function validate(): void
    {
        if ($this->price < 0) {
            throw MovieApplicationException::priceCanNotBeNegative();
        }
    }
}
