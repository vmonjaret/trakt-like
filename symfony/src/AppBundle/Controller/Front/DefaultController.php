<?php

namespace AppBundle\Controller\Front;

use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
use FOS\UserBundle\Model\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, MovieDb $movieDb, MovieManager $movieManager)
    {
        $movies = $movieDb->getPopular(1, 5);

        $user = $this->getUser()->getMoviesLiked();
        dump($user);

        return $this->render('front/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'movies' => $movies
        ]);
    }
}
