<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Movie;
use AppBundle\Entity\Notation;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NotationFixture extends Fixture
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

        for ($i = 0; $i < 30; $i++) {
            $notation = $this->getNotation($users[rand(0, $nbUser)], $movies[rand(0, $nbMovie)], $manager);
            if ($notation->getMark() != null) {
                $i--;
            } else {
                $notation->setMark(rand(1, 5));
                $manager->persist($notation);
            }
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [ MovieFixture::class, UserFixture::class ];
    }

    public function getNotation(User $user, Movie $movie, ObjectManager $manager)
    {
        $notation = $manager->getRepository(Notation::class)->findOneBy([
            "movie" => $movie,
            "user" => $user
        ]);

        if ($notation == null) {
            $notation = new Notation($user, $movie);
        }

        return $notation;
    }
}