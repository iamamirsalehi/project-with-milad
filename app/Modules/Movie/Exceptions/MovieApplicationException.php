<?php

namespace App\Modules\Movie\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class MovieApplicationException extends BusinessException
{
    private const COULD_NOT_FIND_MOVIE = 'could not find movie';
    private const COULD_NOT_UPLOAD_VIDEO = 'could not upload video';
    private const MOVIE_ALREADY_EXISTS = 'movie already exists';
    private const NO_SEARCH_RESULT_FOR_THE_IMDBID = 'no search result for the imdb id';

    public static function movieAlreadyExists(): self
    {
        return new self(self::MOVIE_ALREADY_EXISTS);
    }

    public static function couldNotFindMovie(): self
    {
        return new self(self::COULD_NOT_FIND_MOVIE);
    }

    public static function couldNotUploadVideo(): self
    {
        return new self(self::COULD_NOT_UPLOAD_VIDEO);
    }

    public static function noSearchResultForTheIMDBID(): self
    {
        return new self(self::NO_SEARCH_RESULT_FOR_THE_IMDBID);
    }
}
