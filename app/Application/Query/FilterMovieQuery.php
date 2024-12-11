<?php

namespace App\Application\Query;

use App\Domain\Model\Movie\GenreName;

final class FilterMovieQuery
{
    private ?GenreName $genreName = null;

    public function setGenreName(GenreName $genreName): void
    {
        $this->genreName = $genreName;
    }

    public function getGenreName(): ?GenreName
    {
        return $this->genreName;
    }
}
