<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    public static function findByIMDBID(string $imdbID): ?self
    {
        return self::query()->where('imdb_id', $imdbID)->first();
    }
}
