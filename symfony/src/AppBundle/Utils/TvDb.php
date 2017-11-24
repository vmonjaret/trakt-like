<?php

namespace AppBundle\Utils;

class TvDb
{
    private $api;

    /**
     * TvDb constructor.
     * @param $api
     */
    public function __construct( Api $api )
    {
        $this->api = $api;
    }

    public function searchTv( string $query, string $language = 'fr-FR' ): array
    {
        $query = urlencode($query);
        $url = "search/tv?language={$language}&query={$query}";

        return $this->api->callForTMDb($url)[ 'results' ];
    }

    public function getTvDetails( int $tmdbId, string $language = 'fr-FR'): array
    {
        $url = "tv/{$tmdbId}?language={$language}";

        return $this->api->callForTMDb($url);
    }

    public function getGenres( string $language = 'fr-FR' ): array
    {
        $url = "genre/tv/list?language={$language}";

        return $this->api->callForTMDb($url)['genres'];
    }
}