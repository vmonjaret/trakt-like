<?php

namespace AppBundle\Controller\Back;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/users")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Paginator $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, EntityManagerInterface $em, Paginator $paginator)
    {
        $pagination = $paginator->paginate(
            $em->getRepository(User::class)->findAllQuery(),
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('back/user/index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/{id}", name="user_show")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction(User $user)
    {
        return $this->render('back/user/show.html.twig', [
            'user' => $user
        ]);
    }
}