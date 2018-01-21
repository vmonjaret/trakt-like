<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Movie;
use AppBundle\Entity\Notation;
use AppBundle\Entity\User;
use AppBundle\Form\ContactType;
use AppBundle\Utils\MovieDb;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Method("GET")
     * @param MovieDb $movieDb
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Request $request
     * @internal param MovieManager $movieManager
     */
    public function indexAction(MovieDb $movieDb)
    {
        $movies = $movieDb->getPopular(1, 5);

        return $this->render('front/default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = (new \Swift_Message($data['subject']))
                ->setFrom($data['email'])
                ->setTo('vmonjaret@gmail.com')
                ->setBody($data["message"], 'text/html');

            $mailer->send($message);

            $this->addFlash("success", "Mail envoyé avec succés");
            return $this->redirectToRoute('homepage');
        }

        return $this->render("front/contact.html.twig", array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/cgu", name="cgu")
     * @Method("GET")
     */
    public function cguAction()
    {
        return $this->render('front/cgu.html.twig');
    }

    /**
     * @Route("/legals-mentions", name="legalsMentions")
     */
    public function legalsMentionsAction()
    {
        return $this->render('front/legals_mentions.html.twig');
    }

    /**
     * @Route("/user-movies-taste", name="userMoviesTaste")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userMovieTasteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $movies = $em->getRepository(Movie::class)->findPopularQuery()->setMaxResults(12)->getResult();

        return $this->render('@FOSUser/Registration/select_movies.html.twig', array(
            'movies' => $movies
        ));
    }

    /**
     * @Route("/user-genre-taste", name="userGenreTaste")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function userGenreTasteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $genres = $em->getRepository(Genre::class)->findAll();

        return $this->render('@FOSUser/Registration/select_movies_genre.html.twig', array(
            'genres' => $genres
        ));
    }

    /**
     * Finds and displays a movie entity.
     *
     * @Route("/random", name="movie_random")
     * @Method("GET")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param Movie $movie
     * @internal param MovieDb $movieDb
     */
    public function randomAction()
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository(User::class)->random($this->getUser()->getId(), $em);

        $movieRepo = $em->getRepository(Movie::class);
        $movie = $movieRepo->find($query[0]['id']);

        return $this->redirectToRoute('movie_show', ['slug' => $movie->getSlug()]);
    }
}
