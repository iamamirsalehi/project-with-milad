<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class IMDBVote
{
    public function __construct(private int $IMDBVote)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(): int
    {
        $this->validate();

        return $this->IMDBVote;
    }

    /**
     * @throws MovieApplicationException
     */
    private function validate(): void
    {
        if ($this->IMDBVote < 0) {
            throw MovieApplicationException::iMDBVoteMustBeGreaterThan0();
        }
    }
}
