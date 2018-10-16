<?php

namespace App\Repository;

use App\Entity\Entry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class EntryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entry::class);
    }

    /**
     * @return Entry[]
     */
    public function findByTitlePart(string $titlePart): array
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.title LIKE :titlePart')
            ->setParameter('titlePart', '%' . $titlePart . '%')
            ->getQuery()
            ->getResult();
    }
}
