<?php

namespace AppBundle\Controller\Back;

use AppBundle\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/comments")
 */
class CommentController extends Controller
{
    /**
     * @Route("/", name="comment_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em, Paginator $paginator)
    {
        $pagination = $paginator->paginate(
            $em->getRepository(Comment::class)->findAllWithUserAndMovieQuery(),
            $request->query->get('page', 1),
            10
        );

        return $this->render('back/comment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/signaled", name="comment_signaled")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listSignaledAction(Request $request, EntityManagerInterface $em, Paginator $paginator)
    {
        $pagination = $paginator->paginate(
            $em->getRepository(Comment::class)->findAllSignaledWithUserAndMovieQuery(),
            $request->query->get('page', 1),
            10
        );

        return $this->render('back/comment/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show")
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(Comment $comment)
    {
        return $this->render('back/comment/show.html.twig', [
            'comment' => $comment
        ]);
    }

    /**
     * @Route("/{id}/publish", name="comment_publish")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Comment $comment
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function publishAction(Request $request, EntityManagerInterface $em, Comment $comment)
    {
        $token = $request->query->get('token');

        if (! $this->isCsrfTokenValid('publish_comment', $token)) {
            throw new Exception("CSRF attack");
        }

        if ($comment->isPublished()) {
            $comment->setPublished(false);
            $this->addFlash("success", "Commentaire dépublié");
        } else {
            $comment->setPublished(true);
            $this->addFlash("success", "Commentaire republié");
        }
        $em->flush();

        return $this->redirectToRoute('comment_show', ['id' => $comment->getId()]);
    }
}
