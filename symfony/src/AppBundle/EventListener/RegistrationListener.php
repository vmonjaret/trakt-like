<?php

namespace AppBundle\EventListener;

use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class RegistrationListener implements EventSubscriberInterface
{

    private $router;

    /**
     * RegistrationListener constructor.
     * @param $route
     */
    public function __construct( UrlGeneratorInterface $router )
    {
        $this->router = $router;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            FOSUserEvents::REGISTRATION_SUCCESS => [ 'onRegistrationSuccess', -10 ],
        ];
    }

    public function onRegistrationSuccess( FormEvent $event )
    {
        $url = $this->router->generate('homepage');

        $event->setResponse(new RedirectResponse($url));
    }
}