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

    public function getLatestPosts($offset = 1, $maxResult = 6): ?Array
    {
      return $this->createQueryBuilder('bp')
        ->orderBy('bp.dateTime', 'DESC')
        ->setFirstResult($offset)
        ->setMaxResults($maxResult)
        ->getQuery()
        ->getResult();
      }

      public function getPostsByUserId($userId, $offset, $maxResult = 6): ?Array
      {
        return $this->createQueryBuilder('bp')
          ->andWhere('bp.user = :val')
          ->setParameter('val', $userId)
          ->setFirstResult($offset)
          ->setMaxResults($maxResult)
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

      public function findByKeywordInTitleOrContent($searchWord, $offset = 1, $maxResult = 6): ?Array
      {
        return $this->createQueryBuilder('bp')
          ->where('bp.title like :val')
          ->orWhere('bp.content like :val')
          ->setParameter('val', '%'.$searchWord.'%')
          ->setFirstResult($offset)
          ->setMaxResults($maxResult)
          ->orderBy('bp.dateTime', 'DESC')
          ->getQuery()
          ->getResult();
      }

      public function findByKeywordAndUserIdInTitleOrContent($userId, $searchWord, $offset = 1, $maxResult = 6): ?Array
      {
        return $this->createQueryBuilder('bp')
          ->where('bp.user = :val1')
          ->andWhere('bp.title like :val2 OR bp.content like :val2')
          ->setParameter('val1', $userId)
          ->setParameter('val2', '%'.$searchWord.'%')
          ->setFirstResult($offset)
          ->setMaxResults($maxResult)
          ->orderBy('bp.dateTime', 'DESC')
          ->getQuery()
          ->getResult();
      }

      public function getPostsCount(): ?int
      {
        return $this->createQueryBuilder('bp')
          ->select('count(bp.id)')
          ->getQuery()
          ->getSingleScalarResult();
      }

      public function getPostsCountByKeywordInTitleOrContent($searchWord): ?int
      {
        return $this->createQueryBuilder('bp')
          ->select('count(bp.id)')
          ->where('bp.title like :val')
          ->orWhere('bp.content like :val')
          ->setParameter('val', '%'.$searchWord.'%')
          ->getQuery()
          ->getSingleScalarResult();
      }

      public function getPostsCountByUserId($userId): ?int
      {
        return $this->createQueryBuilder('bp')
          ->select('count(bp.id)')
          ->where('bp.user = :val')
          ->setParameter('val', $userId)
          ->getQuery()
          ->getSingleScalarResult();
      }

      public function getPostsCountByKeywordInTitleOrContentAndUserId($userId, $searchWord): ?int
      {
        return $this->createQueryBuilder('bp')
          ->select('count(bp.id)')
          ->where('bp.user = :val1')
          ->andWhere('bp.title like :val2 OR bp.content like :val2')
          ->setParameter('val1', $userId)
          ->setParameter('val2', '%'.$searchWord.'%')
          ->getQuery()
          ->getSingleScalarResult();
      }
}
