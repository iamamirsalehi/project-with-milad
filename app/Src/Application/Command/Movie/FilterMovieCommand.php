<?php

namespace App\Src\Application\Command\Movie;

use App\Src\Domain\Model\Movie\GenreName;

final class FilterMovieCommand
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
