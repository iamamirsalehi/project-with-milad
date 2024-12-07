<?php

namespace App\Src\Domain\Service\MovieRentPriceCalculation;

use App\Src\Domain\Exceptions\MovieApplicationException;
use App\Src\Domain\Model\Movie\Duration;
use App\Src\Domain\Model\Subscription\Price;

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
