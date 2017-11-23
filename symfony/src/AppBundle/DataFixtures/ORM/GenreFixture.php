<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Genre;
use AppBundle\Utils\MovieDb;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenreFixture extends Fixture
{
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
        $genres = $this->container->get(MovieDb::class)->getGenres();

        foreach ( $genres as $genre ) {
            $genre = new Genre($genre['id'], $genre['name']);
            $manager->persist($genre);
        }

        $manager->flush();
    }
}