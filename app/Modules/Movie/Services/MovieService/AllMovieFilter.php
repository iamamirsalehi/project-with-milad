<?php

namespace App\Modules\Movie\Services\MovieService;

use App\Modules\Movie\Models\GenreName;

class AllMovieFilter
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
