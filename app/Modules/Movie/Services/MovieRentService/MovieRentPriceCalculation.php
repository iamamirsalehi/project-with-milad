<?php

namespace App\Modules\Movie\Services\MovieRentService;

use App\Modules\Movie\Models\Duration;

class MovieRentPriceCalculation
{
    private const BASE_RENT_FEE = 5000;
    private const ADDITIONAL_COST_PER_DAY = 3000;

    public function calculate(Duration $duration): Duration
    {
        $calculatedDuration = self::BASE_RENT_FEE + ($duration->toPrimitiveType() - 1) * self::ADDITIONAL_COST_PER_DAY;

        return new Duration($calculatedDuration);
    }
}
