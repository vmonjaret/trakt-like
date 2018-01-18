<?php

namespace AppBundle\Controller\Front;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/profile", name="user_profile")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showAction()
    {
        $user = $this->getUser();
        dump($user);

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
        ));
    }
}