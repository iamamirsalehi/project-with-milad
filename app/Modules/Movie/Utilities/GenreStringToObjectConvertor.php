<?php

namespace App\Modules\Movie\Utilities;

use App\Modules\Movie\Models\GenreName;

class GenreStringToObjectConvertor
{
    public static function convert(string $genre): array
    {
        if (empty($genre)) {
            return [];
        }

        $arrayOfGenres = explode(',', $genre);

        $genres = [];
        foreach ($arrayOfGenres as $genre) {
            $genre = strtolower(trim($genre));
            $genres[] = new GenreName($genre);
        }

        return $genres;
    }
}
