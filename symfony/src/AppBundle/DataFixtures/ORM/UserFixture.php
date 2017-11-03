<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserFixture extends Fixture
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
        $userManager = $this->container->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername('vmonjaret');
        $user->setEmail('vmonjaret@gmail.com');
        $user->setPlainPassword('root');
        $user->setEnabled(true);
        $user->setRoles([ 'ROLE_ADMIN' ]);

        $userManager->updateUser($user);
    }
}