<?php

namespace App\Modules\Movie\Models;

use App\Modules\Movie\Enums\MovieStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $title
 * @property string $language
 * @property string $country
 * @property string $poster
 * @property string $url
 * @property MovieStatus $status
 * @property string $imdb_rating
 * @property string $imdb_id
 * @property string imdb_votes
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * */
class Movie extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => MovieStatus::class,
        ];
    }

    public static function findByIMDBID(string $imdbID): ?self
    {
        return self::query()->where('imdb_id', $imdbID)->first();
    }

    public static function exists(string $imdbID): bool
    {
        return self::query()->where('imdb_id', $imdbID)->exists();
    }
}
