<?php

namespace App\Modules\Movie\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class MovieApplicationException extends BusinessException
{
    private const COULD_NOT_FIND_MOVIE = 'could not find movie';
    private const COULD_NOT_UPLOAD_VIDEO = 'could not upload video';
    private const MOVIE_ALREADY_EXISTS = 'movie already exists';
    private const NO_SEARCH_RESULT_FOR_THE_IMDBID = 'no search result for the imdb id';
    private const COULD_NOT_UPDATE_MOVIE_URL = 'could not update movie url';
    private const MOVIE_DOES_NOT_HAVE_VIDEO = 'movie does not have video';
    private const COULD_NOT_CHANGE_STATUS = 'could not change status';
    private const MOVIE_IS_NOT_AVAILABLE = 'movie is not available';
    private const MOVIE_IS_ALREADY_PUBLISHED = 'movie is already published';
    private const MOVIE_IS_ALREADY_DRAFT = 'movie is already drafted';

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

    public static function couldNotUpdateMovieURL(): self
    {
        return new self(self::COULD_NOT_UPDATE_MOVIE_URL);
    }

    public static function noSearchResultForTheIMDBID(): self
    {
        return new self(self::NO_SEARCH_RESULT_FOR_THE_IMDBID);
    }

    public static function movieDoesNotHaveVideo(): self
    {
        return new self(self::MOVIE_DOES_NOT_HAVE_VIDEO);
    }

    public static function couldNotChangeStatus(): self
    {
        return new self(self::COULD_NOT_CHANGE_STATUS);
    }

    public static function movieIsNotAvailable(): self
    {
        return new self(self::MOVIE_IS_NOT_AVAILABLE);
    }

    public static function movieIsAlreadyPublished(): self
    {
        return new self(self::MOVIE_IS_ALREADY_PUBLISHED);
    }

    public static function movieIsAlreadyDraft(): self
    {
        return new self(self::MOVIE_IS_ALREADY_DRAFT);
    }
}
