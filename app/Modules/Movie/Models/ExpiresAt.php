<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use Illuminate\Support\Carbon;

final readonly class ExpiresAt
{
    /**
     * @throws MovieApplicationException
     */
    public function __construct(private string $expiresAt)
    {
        if (Carbon::parse($this->expiresAt)->isPast()) {
            throw MovieApplicationException::invalidExpiresAt();
        }
    }

    public function toCarbon(): Carbon
    {
        return Carbon::parse($this->expiresAt);
    }

    public function __toString(): string
    {
        return $this->expiresAt;
    }
}
