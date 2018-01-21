<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Movie;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CommentFixture extends Fixture
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load( ObjectManager $manager )
    {
        $movies = $manager->getRepository(Movie::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $nbMovie = count($movies) - 1;
        $nbUser = count($users) - 1;

        $faker = \Faker\Factory::create('fr_FR');

        foreach ($movies as $movie) {
            $max = rand(3, 10);
            for ($i = 0; $i < $max; $i++) {
                $comment = new Comment($movies[rand(0, $nbMovie)], $users[rand(0, $nbUser)]);
                $comment->setContent($faker->paragraph);
                $comment->setCreatedAt($faker->dateTime);
                if (rand(0, 5) == 1) {
                    $comment->setSignaled(true);
                }
                if (rand(0, 5) == 2) {
                    $comment->setPublished(false);
                }
                $manager->persist($comment);
            }
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [ MovieFixture::class, UserFixture::class ];
    }

}