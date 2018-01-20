<?php

namespace AppBundle\Repository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByMovieWithUsernameAndAvatar($movieId)
    {
        $query = $this->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->addSelect('u.username, u.avatar')
            ->where('c.movie = :id')
            ->setParameter('id', $movieId)
            ->getQuery();

        return $query->getResult();
    }
}
