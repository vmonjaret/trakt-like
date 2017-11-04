<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class MovieFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load( ObjectManager $manager )
    {
        $movie = new Movie();
        $movie->setTitle("Deadpool");
        $movie->setShortPlot("Une petite description");
        $movie->setLongPlot("Deadpool, est l'anti-héros le plus atypique de l'univers Marvel. A l'origine, il s'appelle Wade Wilson : un ancien militaire des Forces Spéciales devenu mercenaire. Après avoir subi une expérimentation hors norme qui va accélérer ses pouvoirs de guérison, il va devenir Deadpool. Armé de ses nouvelles capacités et d'un humour noir survolté, Deadpool va traquer l'homme qui a bien failli anéantir sa vie.");
        $movie->setReleaseDate(new \DateTime());
        $movie->setPoster("https://upload.wikimedia.org/wikipedia/en/4/46/Deadpool_poster.jpg");
        $movie->setSlug("deadpool");
        $movie->setRuntime(180);

        $manager->persist($movie);
        $manager->flush();
    }
}