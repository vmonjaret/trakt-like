<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Movie;
use AppBundle\Utils\MovieDb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @Route("/", name="movie_index")
     * @Method("GET")
     * @param MovieDb $movieDb
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(MovieDb $movieDb)
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $movieDb->getPopular();

        return $this->render('front/movie/index.html.twig', array(
            'movies' => $movies['movies'],
            'totalPage' => $movies['totalPage']
        ));
    }

    /**
     * Finds and displays a movie entity.
     *
     * @Route("/{id}", name="movie_show")
     * @Method("GET")
     */
    public function showAction(Movie $movie)
    {

        return $this->render('front/movie/show.html.twig', array(
            'movie' => $movie,
        ));
    }
}
