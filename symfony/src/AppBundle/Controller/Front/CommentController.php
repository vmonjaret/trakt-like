<?php

namespace AppBundle\Controller\Front;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Comment controller.
 *
 * @Route("comment")
 */
class CommentController extends Controller
{

    /**
     * @Route("/{slug}", name="movie_all_comments")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @param EntityManagerInterface $em
     * @return Response
     * @internal param Request $request
     * @internal param Movie $movie
     */
    public function indexAction($slug, EntityManagerInterface $em)
    {
        $movie = $em->getRepository(Movie::class)->findOneBySlugWithGenres($slug);
        $comments = $em->getRepository(Comment::class)->findByMovieWithUsernameAndAvatar($movie->getId());

        return $this->render('front/comment/index.html.twig', [
            'movie'=> $movie,
            'comments' => $comments
        ]);
    }
}