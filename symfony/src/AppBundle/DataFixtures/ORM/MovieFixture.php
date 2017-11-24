<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Movie;
use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MovieFixture extends Fixture
{
    protected $container;

    public function setContainer( ContainerInterface $container = null )
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load( ObjectManager $manager )
    {
        $movieDb = $this->container->get(MovieDb::class);
        $movieManager = $this->container->get(MovieManager::class);

        $request = $movieDb->searchMovie('deadpool');

        foreach ( $request as $movie ) {
            $movie = $movieDb->getMovieDetails($movie['id']);
            $movie = $movieManager->createFromArray($movie);
            $manager->persist($movie);
        }

        $request = $movieDb->searchMovie('star wars');
        foreach ( $request as $movie ) {
            $movie = $movieDb->getMovieDetails($movie['id']);
            $movie = $movieManager->createFromArray($movie);
            $manager->persist($movie);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ GenreFixture::class ];
    }


}