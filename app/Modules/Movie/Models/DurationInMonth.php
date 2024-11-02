<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class DurationInMonth
{
    public function __construct(private int $month)
    {

    }

    /**
     * @throws MovieApplicationException
     */
    public function get(): int
    {
        $this->validate();

        return $this->month;
    }

    /**
     * @throws MovieApplicationException
     */
    private function validate(): void
    {
        if ($this->month < 0) {
            throw MovieApplicationException::durationInMonthCanNotBeNegative();
        }
    }
}
