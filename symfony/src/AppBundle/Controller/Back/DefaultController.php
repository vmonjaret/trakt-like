<?php

namespace AppBundle\Controller\Back;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Manager\MovieManager;
use AppBundle\Utils\MovieDb;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="dashboard")
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $users = $em->getRepository(User::class)->countAll();
        $comments = $em->getRepository(Comment::class)->countAll();
        $commentsSignaled = $em->getRepository(Comment::class)->countSignaled();

        return $this->render('back/default/index.html.twig', [
            'users' => $users,
            'comments' => $comments,
            'commentsSignaled' => $commentsSignaled
        ]);
    }
}
