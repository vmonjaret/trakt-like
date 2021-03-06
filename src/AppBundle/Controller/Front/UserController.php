<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    /**
     * @Route("/profile", name="user_profile")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function showAction()
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $nbHoursMoviesStats = $em->getRepository(User::class)->getNbHoursMovie($user->getId());

        $nbComments = $em->getRepository(User::class)->countAllComments($user->getId());
        $nbNotations = $em->getRepository(User::class)->countAllNotations($user->getId());

        $days = floor ($nbHoursMoviesStats[2] / 1440);
        $hours = floor (($nbHoursMoviesStats[2] - $days * 1440) / 60);
        $minutes = $nbHoursMoviesStats[2] - ($days * 1440) - ($hours * 60);

        $nbHoursMovies = $days . " jours, " . $hours . " heures et " . $minutes . " minutes";

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'user' => $user,
            'nbWatchedMovies' => $nbHoursMoviesStats[1],
            'nbHoursMovies' => $nbHoursMovies,
            'nbComments' => $nbComments,
            'nbNotations' => $nbNotations
        ));
    }
}