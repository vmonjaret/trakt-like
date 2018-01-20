<?php

namespace AppBundle\Controller\Front;

use AppBundle\Entity\Genre;
use AppBundle\Entity\Movie;
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
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'movies' => $movies
        ]);
    }

    /**
     * @Route("/contact", name="contact")
     * @Method("GET")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contactAction(Request $request)
    {
        $form = $this->createForm("AppBundle\Form\ContactType",null,array(
            "action" => $this->generateUrl("contact"),
            "method" => "POST"
        ));

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){
                    $data = $form->getData();
                    return $this->render("front/contact/send_email.html.twig", array(
                        "name" => $data["name"]
                    ));
                }else{
                    var_dump("Error :(");
                }
            }
        }

        return $this->render("front/contact.html.twig", array(
            'form' => $form->createView()
        ));
    }

    private function sendEmail($data){
        $myappContactMail = "haasmyriam8@gmail.com";
        $myappContactPassword = "Kosima70";

        $transport = \Swift_SmtpTransport::newInstance("smtp.gmail.com", 465,"ssl")
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Random Movie - ". $data["subject"])
            ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
            ->setTo(array($data["email"] => $data["email"]))
            ->setBody($data["message"]."<br>ContactMail :".$data["email"], 'text/html');

        return $mailer->send($message);
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
}
