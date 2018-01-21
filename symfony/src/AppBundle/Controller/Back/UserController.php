<?php

namespace AppBundle\Controller\Back;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Paginator;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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

    /**
     * @Route("/{id}/disable", name="user_disable")
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function disableAction(Request $request, User $user, EntityManagerInterface $em)
    {
        $token = $request->query->get('token');

        if (!$this->isCsrfTokenValid('disable_user', $token)) {
            throw new Exception("CSRF attack");
        }

        if ($user->isEnabled()) {
            $user->setEnabled(false);
            $this->addFlash("success", "Utilisateur désactivé");
        } else {
            $user->setEnabled(true);
            $this->addFlash("success", "Utilisateur activé");
        }
        $em->flush();

        return $this->redirectToRoute('user_show', ['id' => $user->getId()]);
    }
}