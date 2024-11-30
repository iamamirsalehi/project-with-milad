<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

final readonly class IMDBVote
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private int $IMDBVote)
    {
        if ($this->IMDBVote < 0) {
            throw MovieApplicationException::iMDBVoteMustBeGreaterThan0();
        }
    }

    public function toPrimitiveType(): int
    {
        return $this->IMDBVote;
    }

    public function __toString(): string
    {
        return $this->toPrimitiveType();
    }
}
