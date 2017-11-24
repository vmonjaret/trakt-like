<?php

namespace AppBundle\Utils;

class Api
{
    private $apiKey;

    public function __construct($apiKey) {
        $this->apiKey = $apiKey;
    }

    public function callApi( string $url, string $method = "GET", $data = null ): array
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

    public function callForTMDb(string $url, string $method = "GET", $data = null) : array
    {
        $baseUrl = 'https://api.themoviedb.org/3';

        $encodedUrl = "{$baseUrl}/{$url}&api_key={$this->apiKey}";

        return $this->callApi($encodedUrl, $method, $data);
    }
}