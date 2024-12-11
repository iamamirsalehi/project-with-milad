<?php

namespace App\Domain\Exceptions;

final class MovieApplicationException extends BusinessException
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
    private const VIDEO_TEMP_PATH_DOES_NOT_EXIST = 'video path does not exist';
    private const MOVIE_IS_ALREADY_ADDED_TO_FAVORITES_LIST = 'movie is already added to favorites list';
    private const USER_DOES_NOT_HAVE_ANY_FAVORITES_MOVIE = 'user does not have any favorite movie';
    private const MOVIE_IS_NOT_IN_FAVORITES_LIST = 'movie is not in favorites list';
    private const FAVORITE_MOVIE_IS_ALREADY_REMOVED = 'favorite movie is already removed';
    private const CAN_NOT_HAVE_MORE_THAN_TWO_RENTED_MOVIE = 'can not have more than two rented movie';
    private const INVALID_MOVIE_ID = 'invalid movie id';
    private const INVALID_MOVIE_RENT_ID = 'invalid movie rent id';
    private const INVALID_EXPIRES_AT = 'invalid expires at';
    private const INVALID_HOURS = 'invalid hours';
    private const INVALID_MOVIE_GENRE_ID = 'invalid movie genre id';
    private const INVALID_MOVIE_GENRE_NAME = 'invalid movie genre name';
    private const INVALID_GENRE_ID = 'invalid genre id';
    private const MOVIE_RENT_DOES_NOT_EXIST = 'movie rent does not exist';
    private const MOVIE_RENT_IS_ALREADY_ACTIVATED = 'movie rent is already activated';
    private const MOVIE_RENT_IS_ALREADY_STARTED_TO_WATCHING = 'movie rent is already started to watching';
    private const MOVIE_IS_NOT_ACCESSIBLE = 'movie is not accessible';

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

    public static function videoTempPathDoesNotExist(): self
    {
        return new self(self::VIDEO_TEMP_PATH_DOES_NOT_EXIST);
    }

    public static function movieIsAlreadyAddedToFavoritesList(): self
    {
        return new self(self::MOVIE_IS_ALREADY_ADDED_TO_FAVORITES_LIST);
    }

    public static function userDoesNotHaveAnyFavoritesMovie(): self
    {
        return new self(self::USER_DOES_NOT_HAVE_ANY_FAVORITES_MOVIE);
    }

    public static function movieIsNotInFavoritesList(): self
    {
        return new self(self::MOVIE_IS_NOT_IN_FAVORITES_LIST);
    }

    public static function favoriteMovieIsAlreadyRemoved(): self
    {
        return new self(self::FAVORITE_MOVIE_IS_ALREADY_REMOVED);
    }

    public static function canNotHaveMoreThanTwoRentedMovie(): self
    {
        return new self(self::CAN_NOT_HAVE_MORE_THAN_TWO_RENTED_MOVIE);
    }

    public static function invalidMovieID(): self
    {
        return new self(self::INVALID_MOVIE_ID);
    }

    public static function invalidMovieRentID(): self
    {
        return new self(self::INVALID_MOVIE_RENT_ID);
    }

    public static function invalidExpiresAt(): self
    {
        return new self(self::INVALID_EXPIRES_AT);
    }

    public static function invalidHours(): self
    {
        return new self(self::INVALID_HOURS);
    }

    public static function invalidMovieGenreID(): self
    {
        return new self(self::INVALID_MOVIE_GENRE_ID);
    }

    public static function invalidMovieGenreName(): self
    {
        return new self(self::INVALID_MOVIE_GENRE_NAME);
    }

    public static function invalidGenreID(): self
    {
        return new self(self::INVALID_GENRE_ID);
    }

    public static function movieRentDoesNotExist(): self
    {
        return new self(self::MOVIE_RENT_DOES_NOT_EXIST);
    }

    public static function movieRentIsAlreadyActivated(): self
    {
        return new self(self::MOVIE_RENT_IS_ALREADY_ACTIVATED);
    }

    public static function movieRentIsAlreadyStartedToWatching(): self
    {
        return new self(self::MOVIE_RENT_IS_ALREADY_STARTED_TO_WATCHING);
    }

    public static function movieIsNotAccessible(): self
    {
        return new self(self::MOVIE_IS_NOT_ACCESSIBLE);
    }
}
