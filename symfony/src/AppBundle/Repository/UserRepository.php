<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    public function userLikedMovies(User $user){
        $query = $this->createQueryBuilder('u')
            ->from('AppBundle:User', 'u')
            ->where('u.id = :user')
            ->setParameter('user', $user->getId());

        return $query->getQuery()->getFirstResult() !== null;
    }
}
