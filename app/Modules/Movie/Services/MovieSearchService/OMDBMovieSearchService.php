<?php

namespace App\Modules\Movie\Services\MovieSearchService;

use App\Modules\Movie\Exceptions\MovieApplicationException;
use App\Modules\Movie\Models\Country;
use App\Modules\Movie\Models\IMDBID;
use App\Modules\Movie\Models\IMDBRating;
use App\Modules\Movie\Models\IMDBVote;
use App\Modules\Movie\Models\Language;
use App\Modules\Movie\Models\Poster;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class OMDBMovieSearchService implements IMovieSearchService
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
        $url = sprintf("%s&i=%s", $this->baseURL, $imdbID->get());

        return $this->sendRequest($url);
    }

    private function sendRequest(string $url): MovieInfo
    {
        $response = Http::get($url);

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
            new IMDBVote($this->imdbVoteToInt($parsedBody['imdbVotes']))
        );
    }

    private function imdbVoteToInt(string $imdbVote): int
    {
        return intval(str_replace(',', '', $imdbVote));
    }
}
