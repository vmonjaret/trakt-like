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

    public function createFromArray( array $request ): Movie
    {
        $movie = new Movie();

        $movie->setTmDbId($request['id']);
        $movie->setTitle($request['title']);
        $movie->setPoster($request['poster_path']);
        $movie->setOverview($request['overview']);
        $movie->setRuntime($request['runtime']);
        if ( $request['release_date'] !== '' ) {
            $movie->setReleaseDate(\DateTime::createFromFormat('Y-m-d', $request['release_date']));
        }

        foreach ( $request[ 'genres' ] as $genre ) {
            $genre = $this->em->getRepository(Genre::class)->findOneByTmDbId($genre['id']);
            $movie->addGenre($genre);
        }

        $this->em->persist($movie);
        $this->em->flush();

        return $movie;
    }
}