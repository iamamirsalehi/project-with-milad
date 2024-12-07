<?php

namespace App\Src\Domain\Model\Movie;

use App\Src\Instrastructure\Cast\Movie\GenreIDCast;
use App\Src\Instrastructure\Cast\Movie\MovieGenreIDCast;
use App\Src\Instrastructure\Cast\Movie\MovieIDCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read MovieGenreID $id
 * @property-read MovieID $movie_id
 * @property-read GenreID $genre_id
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
final class MovieGenre extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => MovieGenreIDCast::class,
            'movie_id' => MovieIDCast::class,
            'genre_id' => GenreIDCast::class,
        ];
    }

    public static function new(MovieID $movieID, GenreID $genreID): self
    {
        $movieGenre = new self();

        $movieGenre->movie_id = $movieID;
        $movieGenre->genre_id = $genreID;

        return $movieGenre;
    }
}
