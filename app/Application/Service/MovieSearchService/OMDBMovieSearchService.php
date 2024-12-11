<?php

namespace App\Application\Service\MovieSearchService;

use App\Domain\Exceptions\MovieApplicationException;
use App\Domain\Model\Movie\Country;
use App\Domain\Model\Movie\GenreName;
use App\Domain\Model\Movie\IMDBID;
use App\Domain\Model\Movie\IMDBRating;
use App\Domain\Model\Movie\IMDBVote;
use App\Domain\Model\Movie\Language;
use App\Domain\Model\Movie\Poster;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

final class OMDBMovieSearchService implements IMovieSearchService
{
    private string $baseURL;

    public function __construct(private readonly string $apiKey)
    {
        $this->baseURL = sprintf("https://www.omdbapi.com/?apikey=%s", $this->apiKey);
    }

    /**
     * @throws MovieApplicationException
     */
    public function searchByIMDBID(IMDBID $imdbID): MovieInfo
    {
        $url = sprintf("%s&i=%s", $this->baseURL, $imdbID);

        return $this->sendRequest($url);
    }

    /**
     * @throws MovieApplicationException
     */
    private function sendRequest(string $url): MovieInfo
    {
        try {
            $response = Http::get($url);
        }catch (\Exception $exception){
            throw new \RuntimeException('could not fetch the movie please try again');
        }

        if ($response->getStatusCode() != Response::HTTP_OK) {
            throw MovieApplicationException::noSearchResultForTheIMDBID();
        }

        $body = $response->body();
        $parsedBody = json_decode($body, true);

        return new MovieInfo(
            $parsedBody['Title'],
            new Language($parsedBody['Language']),
            new Country($parsedBody['Country']),
            new Poster($parsedBody['Poster']),
            new IMDBRating(floatval($parsedBody['imdbRating'])),
            new IMDBID($parsedBody['imdbID']),
            new IMDBVote($this->imdbVoteToInt($parsedBody['imdbVotes'])),
            $this->convertStringGenreToGenreNameObject($parsedBody['Genre']),
        );
    }

    private function imdbVoteToInt(string $imdbVote): int
    {
        return intval(str_replace(',', '', $imdbVote));
    }

    /**
     * @throws MovieApplicationException
     */
    private function convertStringGenreToGenreNameObject(string $genre): array
    {
        if (empty($genre)) {
            return [];
        }

        $arrayOfGenres = explode(',', $genre);

        $genres = [];
        foreach ($arrayOfGenres as $genre) {
            $genre = strtolower(trim($genre));
            $genres[] = new GenreName($genre);
        }

        return $genres;
    }
}
