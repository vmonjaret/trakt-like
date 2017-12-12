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
        $this->createFromRequest('deadpool', $manager);
        $this->createFromRequest('star wars', $manager);
        $this->createFromRequest('hunger games', $manager);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ GenreFixture::class ];
    }

    private function createFromRequest( string $request, ObjectManager $manager )
    {
        $movieDb = $this->container->get(MovieDb::class);
        $movieManager = $this->container->get(MovieManager::class);

        $request = $movieDb->search($request);
        foreach ( $request as $movie ) {
            $movie = $movieDb->getDetails($movie['id']);
            $movie = $movieManager->createFromArray($movie);
            if ($movie) {
                $manager->persist($movie);
            }
        }
    }

}