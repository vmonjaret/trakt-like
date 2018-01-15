<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Model\UserInterface;

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


class ProfileController extends ContainerAware
{
    public function showAction()
    {
        $response = parent::showAction();

        dump('ok');

        die();
        return $response;
    }

    /**
     * Show the user
     */
   /* public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        if ( !is_object($user) || !$user instanceof UserInterface ) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $bookOwned = $this->container->get('doctrine')
            ->getManager()
            ->getRepository(BookOwned::class)
            ->findByUser($user);

        return $this->container->get('templating')
            ->renderResponse('FOSUserBundle:Profile:show.html.' . $this->container->getParameter('fos_user.template.engine'), [
                'user'      => $user,
                'bookOwned' => $bookOwned,
            ]);
    }*/
}
