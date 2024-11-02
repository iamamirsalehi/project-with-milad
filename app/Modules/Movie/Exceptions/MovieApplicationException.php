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
    private const IMDBID_MUST_BE_ATLEAST_9_CHARACTERS = 'imdb id must at least 9 characters';
    private const IMDBID_MUST_START_WITH_TT = 'imdb id must start with tt';
    private const IMDBID_MUST_CONTAINT_INTEGER_AFTER_TT = 'imdb id must contain integer after tt';
    private const INVALID_POSTER_URL = 'invalid poster url';
    private const IMDB_RATING_MUST_BE_BETWEEN_0_AND_10 = 'imdb rating must be between 0 and 10';
    private const IMDB_VOTE_MUST_BE_GREATER_THAN_0 = 'imdb vote must be greater than 0';
    private const PRICE_CAN_NOT_BE_NEGATIVE = 'price can not be negative';
    private const DURATION_IN_MONTH_CAN_NOT_BE_NEGATIVE = 'duration in month cannot be negative';

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

    public static function iMDBIDMustBeAtLeast9Character(): self
    {
        return new self(self::IMDBID_MUST_BE_ATLEAST_9_CHARACTERS);
    }

    public static function iMDBIDMustStartWithTT(): self
    {
        return new self(self::IMDBID_MUST_START_WITH_TT);
    }

    public static function iMDBIDMustContainIntegerAfterTT(): self
    {
        return new self(self::IMDBID_MUST_CONTAINT_INTEGER_AFTER_TT);
    }

    public static function invalidPosterURL(): self
    {
        return new self(self::INVALID_POSTER_URL);
    }

    public static function iMDBRatingMustBeBetween0And10(): self
    {
        return new self(self::IMDB_RATING_MUST_BE_BETWEEN_0_AND_10);
    }

    public static function iMDBVoteMustBeGreaterThan0(): self
    {
        return new self(self::IMDB_VOTE_MUST_BE_GREATER_THAN_0);
    }

    public static function priceCanNotBeNegative(): self
    {
        return new self(self::PRICE_CAN_NOT_BE_NEGATIVE);
    }

    public static function durationInMonthCanNotBeNegative(): self
    {
        return new self(self::DURATION_IN_MONTH_CAN_NOT_BE_NEGATIVE);
    }
}
