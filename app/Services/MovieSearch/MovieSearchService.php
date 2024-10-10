<?php

namespace App\Services\MovieSearch;

use App\Models\Movie;
use App\Services\MovieDataProvider\MovieDataProviderInterface;

class MovieSearchService implements MovieSearchInterface
{
    public function __construct(private MovieDataProviderInterface $movieDataProvider)
    {
    }

    public function search(MovieSearchDto $dto): ?Movie
    {
        $movie = Movie::query()
            ->when($dto->getTitle(), function ($query) use ($dto) {
                $query->where('title', 'like', '%' . $dto->getTitle() . '%');
            })->when($dto->getImdbID(), function ($query) use ($dto) {
                $query->where('imdb_id', 'like', '%' . $dto->getImdbID() . '%');
            })->first();

        if (!is_null($movie)) {
            return $movie;
        }

        if ($dto->getTitle()) {
            $searchedMovie = $this->movieDataProvider->searchByTitle($dto->getTitle());
        } else {
            $searchedMovie = $this->movieDataProvider->searchByImdbID($dto->getImdbID());
        }

        if (!$searchedMovie) {
            return null;
        }

        return Movie::query()->create([
            'title' => $searchedMovie->getTitle(),
            'language' => $searchedMovie->getLanguage(),
            'country' => $searchedMovie->getCountry(),
            'poster' => $searchedMovie->getPoster(),
            'imdb_rating' => $searchedMovie->getImdbRating(),
            'imdb_id' => $searchedMovie->getImdbID(),
            'imdb_votes' => $searchedMovie->getImdbVotes()
        ]);
    }
}
