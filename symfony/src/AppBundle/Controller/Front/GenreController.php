<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Genre;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Genre controller.
 *
 * @Route("genre")
 */
class GenreController extends Controller
{
    /**
     * User like a genre
     *
     * @Route("/like", name="genre_like")
     * @Method("POST")
     * @param Request $request
     * @internal param Genre $genre
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return Response
     */
    public function likeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $genreRepo = $em->getRepository(Genre::class);

        if ($request->isXmlHttpRequest()) {
            $genreId = $request->request->get('genreId');

            $genre = $genreRepo->find($genreId);

            if ($genre != null) {
                $user = $this->getUser();
                $user->addGenreLiked($genre);
                $em->flush();

                return new JsonResponse('Success');
            }

            return new JsonResponse('Error:Genre not found', 400);
        }

        return new Response("Not an AJAX request", 400);
    }
}
