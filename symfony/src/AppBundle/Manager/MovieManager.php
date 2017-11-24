<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityManager;

class MovieManager
{

    private $em;

    /**
     * MovieManager constructor.
     * @param $em
     */
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    /**
     * @param array $request
     * @return Movie|null
     */
    public function createFromArray( array $request )
    {
        if ($request['poster_path'] != '' && $request['release_date'] != '' && $request['overview'] != '') {

            $movie = new Movie();

            $movie->setTmDbId($request['id']);
            $movie->setTitle($request['title']);
            if ($request['poster_path'] !== '') {
                $movie->setPoster($request['poster_path']);
            }
            $movie->setOverview($request['overview']);
            $movie->setRuntime($request['runtime']);
            if ( $request['release_date'] !== '' ) {
                $movie->setReleaseDate(\DateTime::createFromFormat('Y-m-d', $request['release_date']));
            }

            foreach ( $request[ 'genres' ] as $genre ) {
                $genre = $this->em->getRepository(Genre::class)->findOneByTmDbId($genre['id']);
                $movie->addGenre($genre);
            }

            return $movie;
        }

        return null;
    }
}