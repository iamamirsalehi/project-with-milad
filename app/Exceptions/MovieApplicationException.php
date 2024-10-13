<?php

namespace App\Exceptions;

use App\Contracts\Exceptions\BusinessException;

class MovieApplicationException extends BusinessException
{
    private const JUST_PASS_TITLE_OR_IMDBID = 'just pass title or imdb id';
    private const TITLE_OR_IMDBID_IS_REQUIRED = 'title or imdb id is required';
    private const COULD_NOT_FIND_MOVIE = 'could not find movie';
    private const COULD_NOT_UPLOAD_VIDEO = 'could not upload video';

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

    public static function couldNotUploadVideo(): self
    {
        return new self(self::COULD_NOT_UPLOAD_VIDEO);
    }
}
