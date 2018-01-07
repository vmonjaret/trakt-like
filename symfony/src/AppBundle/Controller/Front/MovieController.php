<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Movie;
use AppBundle\Repository\MovieRepository;
use AppBundle\Utils\MovieDb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
        $movies = $em->getRepository(Movie::class)->findAll();

        return $this->render('front/movie/index.html.twig', array(
            'movies' => $movies,
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
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function likeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $movieRepo = $em->getRepository(Movie::class);

        if ($request->isXmlHttpRequest()) {
            $movieId = $request->request->get('movieId');

            $movie = $movieRepo->find($movieId);

            if ($movie != null) {
                $user = $this->getUser();
                if ($movieRepo->hasLikedMovie($movie, $user)) {
                    $user->removeMoviesLiked($movie);
                } else {
                    $user->addMoviesLiked($movie);
                }

                $em->flush();

                return new JsonResponse('Sucess');
            }

            return new JsonResponse('Error:Movie not found', 400);
        }

        return new Response("Not an AJAX request", 400);
    }
}
