<?php

namespace AppBundle\Utils;

class MovieDb
{
    private $api;

    /**
     * MovieDb constructor.
     * @param $api
     */
    public function __construct( Api $api )
    {
        $this->api = $api;
    }

    public function searchMovie( string $query, string $language = 'fr-FR' ): array
    {
        $query = urlencode($query);
        $url = "search/movie?language={$language}&query={$query}";

        return $this->api->callForTMDb($url)[ 'results' ];
    }

    public function getMovieDetails( int $tmdbId, string $language = 'fr-FR'): array
    {
        $url = "movie/{$tmdbId}?language={$language}";

        return $this->api->callForTMDb($url);
    }

    public function getGenres( string $language = 'fr-FR' ): array
    {
        $url = "genre/movie/list?language={$language}";

        return $this->api->callForTMDb($url)['genres'];
    }
}