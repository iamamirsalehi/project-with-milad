<?php

namespace App\Domain\Model\Movie;

use App\Infrastructure\Cast\Movie\GenreIDCast;
use App\Infrastructure\Cast\Movie\MovieGenreNameCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read GenreID $id
 * @property-read GenreName $name_en
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
final class Genre extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => GenreIDCast::class,
            'name' => MovieGenreNameCast::class,
        ];
    }

    public static function new(GenreName $name): self
    {
        $genre = new self();

        $genre->name_en = $name;

        return $genre;
    }
}
