<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Movie;
use AppBundle\Utils\MovieDb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Movie controller.
 *
 * @Route("movie")
 */
class MovieController extends Controller
{
    /**
     * Lists all movie entities.
     *
     * @Route("/{page}", name="movie_index", requirements={"page"="\d+"})
     * @Method("GET")
     * @param MovieDb $movieDb
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $page = 1)
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository(Movie::class)->findAll();

        return $this->render('front/movie/index.html.twig', array(
            'movies' => $movies,
        ));
    }

    /**
     * Finds and displays a movie entity.
     *
     * @Route("/{slug}", name="movie_show")
     * @Method("GET")
     */
    public function showAction(Movie $movie)
    {

        return $this->render('front/movie/show.html.twig', array(
            'movie' => $movie,
        ));
    }
}
