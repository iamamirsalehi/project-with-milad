<?php

namespace App\Services\MovieDataProvider;

use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class OMDBDataProviderService implements MovieDataProviderInterface
{
    private string $baseURL;

    public function __construct(private string $apiKey)
    {
        $this->baseURL = sprintf("https://www.omdbapi.com/?apikey=%s", $this->apiKey);
    }


    public function searchByIMDBID(string $imdbID): ?MovieDataProviderResultDto
    {
        $url = sprintf("%s&i=%s", $this->baseURL, $imdbID);

        return $this->sendRequest($url);
    }

    public function searchByTitle(string $title): ?MovieDataProviderResultDto
    {
        $url = sprintf("%s&t=%s", $this->baseURL, $title);

        return $this->sendRequest($url);
    }

    private function sendRequest(string $url): ?MovieDataProviderResultDto
    {
        $response = Http::get($url);

        if ($response->getStatusCode() != Response::HTTP_OK) {
            return null;
        }

        $body = $response->body();
        $parsedBody = json_decode($body, true);

        $result = new MovieDataProviderResultDto();
        $result->setTitle($parsedBody['Title']);
        $result->setCountry($parsedBody['Country']);
        $result->setLanguage($parsedBody['Language']);
        $result->setPoster($parsedBody['Poster']);
        $result->setImdbID($parsedBody['imdbID']);
        $result->setImdbRating($parsedBody['imdbRating']);
        $result->setImdbVotes($parsedBody['imdbVotes']);

        return $result;
    }
}
