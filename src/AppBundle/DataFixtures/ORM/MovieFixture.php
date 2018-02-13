<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MovieFixture extends Fixture
{
    private $movieDb;
    private $movieManager;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->movieDb = $container->get(MovieDb::class);
        $this->movieManager = $container->get(MovieManager::class);
    }


    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load( ObjectManager $manager )
    {
        for ($i = 1; $i <= 10; $i++) {
            $results = $this->movieDb->getPopular($i);
            foreach ($results as $result) {
                $movieTmp = $this->movieDb->getDetails($result['id']);
                $movie = $this->movieManager->createFromArray($movieTmp);
                if ($movie !== null) {
                    $manager->persist($movie);
                }
            }

            $manager->flush();
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ GenreFixture::class ];
    }

}