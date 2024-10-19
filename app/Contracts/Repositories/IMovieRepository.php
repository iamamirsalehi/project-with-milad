<?php

namespace App\Contracts\Repositories;

use App\Contracts\Repositories\Dto\BaseResult;

interface IMovieRepository extends IRepository
{
    public function exists(string $imdbID): bool;

    public function findByIMDBID(string $imdbID): ?BaseResult;

    public function updateURL(string $imdbID, string $url): void;

    public function changeStatusToPublished(string $imdbID): void;

    public function changeStatusToDraft(string $imdbID): void;
}
