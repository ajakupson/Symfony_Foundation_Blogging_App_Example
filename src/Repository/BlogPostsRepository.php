<?php

namespace App\Repository;

use App\Entity\BlogPosts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPosts|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPosts|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPosts[]    findAll()
 * @method BlogPosts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPosts::class);
    }

    public function getLatestPosts($maxResult = 10): ?Array
    {
      return $this->createQueryBuilder('bp')
        ->orderBy('bp.dateTime', 'DESC')
        ->setMaxResults(10)
        ->getQuery()
        ->getResult();
      }

      public function getPostsByUserId($userId): ?Array
      {
        return $this->createQueryBuilder('bp')
          ->andWhere('bp.user = :val')
          ->setParameter('val', $userId)
          ->orderBy('bp.dateTime', 'DESC')
          ->getQuery()
          ->getResult();
      }

      public function getPostById($postId): ?BlogPosts
      {
        return $this->createQueryBuilder('bp')
          ->andWhere('bp.id = :val')
          ->setParameter('val', $postId)
          ->getQuery()
          ->getOneOrNullResult();
      }
}
