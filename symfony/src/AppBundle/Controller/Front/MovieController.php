<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Notation;
use AppBundle\Entity\User;
use AppBundle\Manager\NotationManager;
use AppBundle\Utils\MovieDb;
use Doctrine\ORM\EntityManagerInterface;
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
     * @return Response
     * @internal param MovieDb $movieDb
     */
    public function indexAction(Request $request, Paginator $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(Movie::class)->findPopularQuery();

        $user = $em->getRepository(User::class)->fullyFindById($this->getUser()->getId());

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            Movie::NUM_ITEMS
        );

        return $this->render('front/movie/index.html.twig', array(
            'pagination' => $pagination,
            'user' => $user,
        ));
    }

    /**
     * Finds and displays a movie entity.
     *
     * @Route("/{slug}", name="movie_show")
     * @Method("GET")
     * @param Movie $movie
     * @param MovieDb $movieDb
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function showAction($slug, MovieDb $movieDb, EntityManagerInterface $em)
    {
        $movie = $em->getRepository(Movie::class)->findOneBySlugWithGenres($slug);
        $actors = $movieDb->getActors($movie->getTmDbId());
        $recommendations = $movieDb->getRecommendations($movie->getTmDbId(), 3);
        $notation = null;
        $user = null;

        if (null !== $this->getUser()) {
            $user = $em->getRepository(User::class)->fullyFindById($this->getUser()->getId());
            $notation = $em->getRepository(Notation::class)->findOneBy([
                'movie' => $movie,
                'user' => $this->getUser()
            ]);
        }

        return $this->render('front/movie/show.html.twig', array(
            'movie' => $movie,
            'actors'=> $actors,
            'recommendations' => $recommendations,
            'notation' => $notation,
            'user' => $user,
        ));
    }

    /**
     * Like a movie
     *
     * @Route("/like", name="movie_like", options={"expose"=true})
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
     * @Route("/watch", name="movie_watched", options={"expose"=true})
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
     * @Route("/wish", name="movie_wish", options={"expose"=true})
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

    /**
     * Give a notation to a movie
     *
     * @Route("/mark", name="movie_mark", options={"expose"=true})
     * @Method("POST")
     * @param Request $request
     * @internal param Movie $movie
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function MarkAction(Request $request, EntityManagerInterface $em, NotationManager $notationManager)
    {
        if ($request->isXmlHttpRequest()) {
            $movieId = $request->request->get('movieId');
            $mark = $request->request->get('mark');

            $movie = $em->getRepository(Movie::class)->find($movieId);

            if ($movie != null) {
                $user = $this->getUser();
                $notationManager->markMovie($user, $movie, $mark);

                return new JsonResponse('Success');
            }

            return new JsonResponse('Error:Movie not found', 400);
        }

        return new Response("Not an AJAX request", 400);
    }
}
