<?php

namespace AppBundle\Utils;

use AppBundle\Manager\MovieManager;
use Doctrine\ORM\EntityManager;

class MovieDb
{
    private $apiKey;
    private $baseUrl = 'https://api.themoviedb.org/3';
    private $movieManager;
    private $em;

    /**
     * MovieDb constructor.
     * @param $apiKey
     * @param MovieManager $movieManager
     * @param EntityManager $em
     */
    public function __construct( $apiKey, MovieManager $movieManager, EntityManager $em )
    {
        $this->apiKey = $apiKey;
        $this->movieManager = $movieManager;
        $this->em = $em;
    }

    public function search( string $query, string $language = 'fr-FR' ): array
    {
        $query = urlencode($query);
        $url = "{$this->baseUrl}/search/movie?language={$language}&query={$query}";

        return $this->callApi($url)[ 'results' ];
    }

    public function getDetails( int $tmdbId, string $language = 'fr-FR'): array
    {
        $url = "{$this->baseUrl}/movie/{$tmdbId}?language={$language}";

        return $this->callApi($url);
    }

    public function getGenres( string $language = 'fr-FR' ): array
    {
        $url = "{$this->baseUrl}/genre/movie/list?language={$language}";

        return $this->callApi($url)['genres'];
    }

    public function getPopular(int $limit = 20, $page = 1, string $language = 'fr-FR'){
        $url = "{$this->baseUrl}/movie/popular?language={$language}&page=$page";

        $apiResults = $this->callApi($url);
        $totalPage = $apiResults['total_pages'];
        $apiResults = array_slice($apiResults['results'], 0, $limit, true);

        $results = [];

        foreach ($apiResults as $result) {
            $result = $this->getDetails($result['id']);
            $myMovie = $this->movieManager->createFromArray($result);
            if (null === $myMovie->getId()) {
                $this->em->persist($myMovie);
            }

            $results[] = $myMovie;
        }

        $this->em->flush();

        return ["totalPage" => $totalPage, "movies" => $results];
    }

    private function callApi( string $url, string $method = "GET", $data = null ): array
    {
        $url .= '&api_key=' . $this->apiKey;
        $curl = curl_init();

        switch ( $method ) {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);
                if ( $data )
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;

            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;

            default:
                if ( $data )
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return json_decode($result, true);
    }
}