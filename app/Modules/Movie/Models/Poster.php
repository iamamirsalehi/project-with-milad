<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class Poster
{
    public function __construct(private string $poster)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(): string
    {
        $this->validate();

        return $this->poster;
    }

    /**
     * @throws MovieApplicationException
     */
    private function validate(): void
    {
        if (false === filter_var($this->poster, FILTER_VALIDATE_URL)) {
            throw MovieApplicationException::invalidPosterURL();
        }
    }
}
