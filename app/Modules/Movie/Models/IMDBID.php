<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Exceptions\MovieApplicationException;

readonly class IMDBID
{
    public function __construct(private string $imdbID)
    {
    }

    /**
     * @throws MovieApplicationException
     */
    public function get(): string
    {
        $this->validate();

        return $this->imdbID;
    }

    /**
     * @throws MovieApplicationException
     */
    private function validate(): void
    {
        if (strlen($this->imdbID) <= 8) {
            throw MovieApplicationException::iMDBIDMustBeAtLeast9Character();
        }

        if (false === str_starts_with($this->imdbID, 'tt')) {
            throw MovieApplicationException::iMDBIDMustStartWithTT();
        }

        $explodedIMDBID = explode('tt', $this->imdbID);
        if (false === is_numeric($explodedIMDBID[1])) {
            throw MovieApplicationException::iMDBIDMustContainIntegerAfterTT();
        }
    }
}
