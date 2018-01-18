<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * UserRepository
 */
class UserRepository extends EntityRepository
{
    public function fullyFindById($id)
    {
        $query = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.id = :id')
            ->leftJoin('u.moviesWatched', 'm')
            ->addSelect('m')
            ->leftJoin('u.moviesLiked', 'ml')
            ->addSelect('ml')
            ->leftJoin('u.moviesWished', 'mw')
            ->addSelect('mw')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            return $query->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}
