<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class MovieManager
{

    private $em;

    /**
     * MovieManager constructor.
     * @param EntityManager $em
     */
    public function __construct( EntityManagerInterface $em)
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

            $movie = $this->em->getRepository(Movie::class)->findOneByTmDbId($request['id']);

            if (null === $movie) {
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
                    $myGenre = $this->em->getRepository(Genre::class)->findOneByTmDbId($genre['id']);
                    if (null === $myGenre) {
                        $myGenre = new Genre($genre['id'], $genre['name']);
                        $this->em->persist($myGenre);
                        $this->em->flush();
                    }
                    $movie->addGenre($myGenre);
                }
            }

            $movie->setPopularity($request['popularity']);

            return $movie;
        }

        return null;
    }
}