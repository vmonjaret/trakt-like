<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Movie;
use AppBundle\Utils\MovieDb;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @param Movie $movie
     * @return Response
     */
    public function showAction(Movie $movie)
    {

        return $this->render('front/movie/show.html.twig', array(
            'movie' => $movie,
        ));
    }

    /**
     * Like a movie
     *
     * @Route("/like", name="movie_like")
     * @Method("POST")
     * @param Request $request
     * @internal param Movie $movie
     * @return Response
     */
    public function likeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if ($request->isXmlHttpRequest()) {
            $movieId = $request->request->get('movieId');

            $user = $this->getUser();

            $user->addMoviesLiked($movieId);
            $em->flush();
        }

        return new Response("Not an AJAX request", 400);
    }
}
