<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class IMDBRating
{
    public function __construct(private float $IMDBRating)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(): float
    {
        $this->validate();

        return $this->IMDBRating;
    }

    /**
     * @throws MovieApplicationException
     */
    private function validate(): void
    {
        if ($this->IMDBRating < 0 || $this->IMDBRating > 10) {
            throw MovieApplicationException::iMDBRatingMustBeBetween0And10();
        }
    }
}
