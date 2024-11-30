<?php

namespace App\Modules\Movie\Services\MovieRentService;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Duration;
use App\Modules\Subscription\Models\Price;

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
