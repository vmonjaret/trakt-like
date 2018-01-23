<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
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

    public function getNbHoursMovie($id)
    {
        $query = $this->createQueryBuilder('u')
            ->select('COUNT(m.id), SUM(m.runtime)')
            ->where('u.id = :id')
            ->leftJoin('u.moviesWatched', 'm')
            ->setParameter('id', $id)
            ->getQuery();

        try {
            $result = $query->getSingleResult();
            return $result;
        } catch (NoResultException $e) {
            return null;
        }
    }

    public function random($id, $em)
    {
        $sql = " 
        SELECT *
          FROM movie
          LEFT JOIN movie_genre as moviesGenre ON moviesGenre.movie_id = movie.id
          where 
          (moviesGenre.genre_id IN (
              SELECT DISTINCT(favoriteMoviesGenre.genre_id) FROM movie
              LEFT JOIN liked_movies as likedMovies ON likedMovies.user_id = :id
              LEFT JOIN movie_genre as favoriteMoviesGenre ON favoriteMoviesGenre.movie_id = likedMovies.movie_id)
              OR moviesGenre.genre_id IN (
              SELECT DISTINCT(favoriteGenres.genre_id) FROM movie
              LEFT JOIN favorite_genres as favoriteGenres ON favoriteGenres.user_id = :id)
          )
          AND movie.id NOT IN (
              SELECT DISTINCT(likedMovies.movie_id) FROM movie
              LEFT JOIN liked_movies as likedMovies ON likedMovies.user_id = :id
          )
          AND movie.id NOT IN (
              SELECT DISTINCT(watchedMovies.movie_id) FROM movie
              LEFT JOIN watched_movies as watchedMovies ON watchedMovies.user_id = :id
          )
          GROUP BY id
          ORDER BY RAND()
        ";

        $params['id'] = $id;

        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function countAll()
    {
        try {
            return $this->createQueryBuilder('u')
                ->select('count(u)')
                ->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function countAllComments($id)
    {
        try {
            return $this->createQueryBuilder('u')
                ->select('count(c.id)')
                ->where('u.id = :id')
                ->leftJoin('u.comments', 'c')
                ->setParameter('id', $id)
                ->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function countAllNotations($id)
    {
        try {
            return $this->createQueryBuilder('u')
                ->select('count(n.movie)')
                ->where('u.id = :id')
                ->leftJoin('u.notations', 'n')
                ->setParameter('id', $id)
                ->getQuery()->getSingleScalarResult();
        } catch (NoResultException $e) {
            return null;
        } catch (NonUniqueResultException $e) {
            return null;
        }
    }

    public function findAllQuery()
    {
        return $this->createQueryBuilder('u')->getQuery();
    }
}
