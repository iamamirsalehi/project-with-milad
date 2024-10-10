<?php

namespace App\Services\MovieDataProvider;

class MovieDataProviderExceptions extends \Exception
{
    private const JUST_PASS_TITLE_OR_IMDBID = 'just pass title or imdb id';
    private const TITLE_OR_IMDBID_IS_REQUIRED = 'title or imdb id is required';
    private const COULD_NOT_FIND_MOVIE = 'could not find movie';

    public static function justPassTitleOrIMDBID(): self
    {
        return new self(self::JUST_PASS_TITLE_OR_IMDBID);
    }

    public static function titleOrIMDBIDIsRequired(): self
    {
        return new self(self::TITLE_OR_IMDBID_IS_REQUIRED);
    }

    public static function couldNotFindMovie(): self
    {
        return new self(self::COULD_NOT_FIND_MOVIE);
    }
}
