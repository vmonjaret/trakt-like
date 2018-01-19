<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Movie;
use AppBundle\Utils\MovieDb;
use Knp\Component\Pager\Paginator;
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
     * @param Request $request
     * @param Paginator $paginator
     * @return Response
     * @internal param MovieDb $movieDb
     */
    public function indexAction(Request $request, Paginator $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $sort = $request->query->get('filter');

        if($sort == "recent") {
            $query = $em->getRepository(Movie::class)->findRecentQuery();
        } else {
            $query = $em->getRepository(Movie::class)->findPopularQuery();
        }

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Movie::NUM_ITEMS
        );

        return $this->render('front/movie/index.html.twig', array(
            'pagination' => $pagination
        ));
    }

    /**
     * Finds and displays a movie entity.
     *
     * @Route("/{slug}", name="movie_show")
     * @Method("GET")
     * @param Movie $movie
     * @param MovieDb $movieDb
     * @return Response
     */
    public function showAction(Movie $movie, MovieDb $movieDb)
    {
        $actors = $movieDb->getActors($movie->getTmDbId());
        $recommendations = $movieDb->getRecommendations($movie->getTmDbId(), 3);

        return $this->render('front/movie/show.html.twig', array(
            'movie' => $movie,
            'actors'=> $actors,
            'recommendations' => $recommendations
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
                if ($user->getMoviesLiked()->contains($movie)) {
                    $user->removeMoviesLiked($movie);
                } else {
                    $user->addMoviesLiked($movie);
                }

                $em->flush();

                return new JsonResponse('Success');
            }

            return new JsonResponse('Error:Movie not found', 400);
        }

        return new Response("Not an AJAX request", 400);
    }

    /**
     * Add/remove a movie as watched
     *
     * @Route("/watch", name="movie_watched")
     * @Method("POST")
     * @param Request $request
     * @internal param Movie $movie
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function watchedAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $movieRepo = $em->getRepository(Movie::class);

        if ($request->isXmlHttpRequest()) {
            $movieId = $request->request->get('movieId');

            $movie = $movieRepo->find($movieId);

            if ($movie != null) {
                $user = $this->getUser();
                if ($user->getMoviesWatched()->contains($movie)) {
                    $user->removeMoviesWatched($movie);
                } else {
                    $user->addMoviesWatched($movie);
                }

                $em->flush();

                return new JsonResponse('Success');
            }

            return new JsonResponse('Error:Movie not found', 400);
        }

        return new Response("Not an AJAX request", 400);
    }

    /**
     * Add/remove a movie from the wish list
     *
     * @Route("/wish", name="movie_wish")
     * @Method("POST")
     * @param Request $request
     * @internal param Movie $movie
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function wishListAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $movieRepo = $em->getRepository(Movie::class);

        if ($request->isXmlHttpRequest()) {
            $movieId = $request->request->get('movieId');

            $movie = $movieRepo->find($movieId);

            if ($movie != null) {
                $user = $this->getUser();
                if ($user->getMoviesWished()->contains($movie)) {
                    $user->removeMoviesWished($movie);
                } else {
                    $user->addMoviesWished($movie);
                }

                $em->flush();

                return new JsonResponse('Success');
            }

            return new JsonResponse('Error:Movie not found', 400);
        }

        return new Response("Not an AJAX request", 400);
    }
}
