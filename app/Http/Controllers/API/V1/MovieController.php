<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\API\V1\GetMovieRequest;
use App\Http\Requests\API\V1\UploadMovieRequest;
use App\Models\Movie;
use App\Services\MovieSearch\MovieSearchDto;
use App\Services\MovieSearch\MovieSearchInterface;
use Symfony\Component\HttpFoundation\Response;

class MovieController
{
    public function __construct(private MovieSearchInterface $movieSearchService)
    {
    }

    public function get(GetMovieRequest $request)
    {
        $dto = new MovieSearchDto();
        if ($request->has('title')) {
            $dto->setTitle($request->get('title'));
        }

        if ($request->has('imdb_id')) {
            $dto->setImdbID($request->get('imdb_id'));
        }

        $movie = $this->movieSearchService->search($dto);

        return response()->json($movie);
    }

    public function upload(UploadMovieRequest $request, $imdbID)
    {
        //TODO: needs to be a service
        $movie = Movie::findByIMDBID($imdbID);
        if (!$movie){
            return response()->json(['message' => 'movie not found'], Response::HTTP_NOT_FOUND);
        }

        $path = $request->file('movie')->store('movies');

        $movie->update([
            'url' => $path,
        ]);

        return response()->json(['message' => 'movie uploaded successfully'], Response::HTTP_OK);
    }
}
