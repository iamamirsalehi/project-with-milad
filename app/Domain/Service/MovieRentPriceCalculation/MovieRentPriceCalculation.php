<?php

namespace App\Domain\Service\MovieRentPriceCalculation;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\Duration;
use App\Domain\Model\Subscription\Price;

final class MovieRentPriceCalculation
{
    private const BASE_RENT_FEE = 5000;
    private const ADDITIONAL_COST_PER_DAY = 3000;

    /**
     * @throws MovieApplicationException
     */
    public function calculate(Duration $duration): Price
    {
        $calculatedDuration = self::BASE_RENT_FEE + ($duration->toPrimitiveType() - 1) * self::ADDITIONAL_COST_PER_DAY;

        return new Price($calculatedDuration);
    }
}
