<?php

namespace App\Repository;

use App\Entity\Build;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Build>
 */
class BuildRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Build::class);
    }

    public function findPublicBuilds()
    {  
        return $this->createQueryBuilder('build')
            ->where('build.visibility = :visibility')
            ->setParameter('visibility', false)
            ->orderBy('build.created', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findBuildsByUser(User $user)
    {
        return $this->createQueryBuilder('build')
            ->where('build.creator = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    public function findLatestPublicBuilds(int $limit = 5)
    {
        return $this->createQueryBuilder('build')
            ->where('build.visibility = :visibility')
            ->setParameter('visibility', false)
            ->orderBy('build.created', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
