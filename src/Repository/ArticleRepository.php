<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findArticlesByUser(User $user)
    {
        return $this->createQueryBuilder('article')
        ->where('article.user = :user')
        ->setParameter('user', $user)
        ->orderBy('article.created', 'DESC')
        ->getQuery()
        ->getResult();
    }

    public function findAllByLastest()
    {
        return $this->createQueryBuilder('article')
        ->orderBy('article.created', 'DESC')
        ->getQuery()
        ->getResult();
    }
}
