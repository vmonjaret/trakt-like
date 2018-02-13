<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comment controller.
 *
 * @Route("/comments")
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

    /**
     * @Route("/{id}/signal", name="comment_signal")
     * @param Request $request
     * @param Comment $comment
     */
    public function signalAction(Request $request, Comment $comment, EntityManagerInterface $em)
    {
        $token = $request->query->get('token');

        if (! $this->isCsrfTokenValid('signal_comment', $token)) {
            throw new Exception('CSRF attack');
        }

        $comment->setSignaled(true);
        $em->flush();

        $this->addFlash("success", "Commentaire signalé");
        return $this->redirectToRoute('movie_show', ['slug' => $comment->getMovie()->getSlug()]);
    }
}