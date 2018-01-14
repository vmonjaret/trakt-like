<?php

namespace AppBundle\Controller\Front;

use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
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
        dump($movies);

        return $this->render('front/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/cgu", name="cgu")
     */
    public function cguAction()
    {
        return $this->render('front/cgu.html.twig');
    }

    /**
     * @Route("/legals-mentions", name="legalsMentions")
     */
    public function legalsMentionsAction()
    {
        return $this->render('front/legals_mentions.html.twig');
    }
}
