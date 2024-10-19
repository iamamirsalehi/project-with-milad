<?php

namespace App\Modules\Movie\Services\MovieSearchService;

use App\Modules\Movie\Exceptions\MovieApplicationException;
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
    public function searchByIMDBID(string $imdbID): MovieInfo
    {
        $url = sprintf("%s&i=%s", $this->baseURL, $imdbID);

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
            $parsedBody['Country'],
            $parsedBody['Language'],
            $parsedBody['Poster'],
            $parsedBody['imdbRating'],
            $parsedBody['imdbID'],
            $parsedBody['imdbVotes']
        );
    }
}
