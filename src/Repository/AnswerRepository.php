<?php

namespace App\Repository;

use App\Entity\Answer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class AnswerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Answer::class);
    }

    /**
     * @return Answer[]
     */
    public function findByPhrase(string $phrase): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.entry LIKE :phrase')
            ->setParameter('phrase', '%' . $phrase . '%')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }
}
