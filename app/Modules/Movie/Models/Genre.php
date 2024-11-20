<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Models\Casts\GenreIDCast;
use App\Modules\Movie\Models\Casts\MovieGenreNameCast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property-read GenreID $id
 * @property-read GenreName $name
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 * */
class Genre extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'id' => GenreIDCast::class,
            'name' => MovieGenreNameCast::class,
        ];
    }
}
