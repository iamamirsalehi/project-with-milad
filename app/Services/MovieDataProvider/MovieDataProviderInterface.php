<?php

namespace App\Services\MovieDataProvider;

interface MovieDataProviderInterface
{
    public function searchByIMDBID(string $imdbID): ?MovieDataProviderResultDto;

    public function searchByTitle(string $title): ?MovieDataProviderResultDto;
}
