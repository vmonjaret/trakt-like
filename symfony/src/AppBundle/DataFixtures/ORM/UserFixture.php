<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Movie;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixture extends Fixture
{
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $admin = $userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('vmonjaret@gmail.com');
        $admin->setPlainPassword('s7xN3BAQ');
        $admin->setEnabled(true);
        $admin->setRoles(['ROLE_SUPER_ADMIN']);

        $userManager->updateUser($admin);

        $teacher = $userManager->createUser();
        $teacher->setUsername('amorin');
        $teacher->setEmail('amorin@slyvent.com');
        $teacher->setPlainPassword('dK6ja9fL');
        $teacher->setEnabled(true);
        $teacher->setRoles(['ROLE_SUPER_ADMIN']);

        $userManager->updateUser($teacher);

        $genres = $manager->getRepository(Genre::class)->findAll();
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $user = $userManager->createUser();
            $user->setUsername($faker->userName);
            $user->setEmail($faker->safeEmail);
            $user->setPlainPassword($faker->password);
            $user->setEnabled(true);
            $this->hydrateWithMovies($manager, $user);

            for ($j = 0; $j < 4; $j++) {
                $tmp = rand(0, count($genres) - 1);
                if (!$user->getGenresFavorite()->contains($genres[$tmp])) {
                    $user->addGenresFavorite($genres[$tmp]);
                }
            }

            $userManager->updateUser($user);
        }
    }

    public function getDependencies()
    {
        return [MovieFixture::class];
    }

    private function hydrateWithMovies(ObjectManager $manager, User $user)
    {
        $movies = $manager->getRepository(Movie::class)->findAll();
        $movieCount = count($movies) - 1;

        for ($i = 0; $i < 10; $i++) {
            $tmp = rand(0, $movieCount);
            if (!$user->getMoviesLiked()->contains($movies[$tmp])) {
                $user->addMoviesLiked($movies[$tmp]);
            }
            $tmp = rand(0, $movieCount);
            if (!$user->getMoviesWatched()->contains($movies[$tmp])) {
                $user->addMoviesWatched($movies[$tmp]);
            }
            $tmp = rand(0, $movieCount);
            if (!$user->getMoviesWished()->contains($movies[$tmp])) {
                $user->addMoviesWished($movies[$tmp]);
            }
        }
    }
}