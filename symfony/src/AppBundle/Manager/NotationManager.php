<?php

namespace AppBundle\Manager;

use AppBundle\Entity\Movie;
use AppBundle\Entity\Notation;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class NotationManager
{
    private $em;

    /**
     * NotationManager constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function markMovie(User $user, Movie $movie, int $mark)
    {
        $notation = $this->em->getRepository(Notation::class)->findOneBy(['movie' => $movie, 'user' => $user]);

        if ($notation == null) {
            $notation = new Notation($user, $movie, $mark);
            $this->em->persist($notation);
        } else {
            $notation->setMark($mark);
        }

        $this->em->flush();
    }
}