<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

/**
 * @method Bundle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bundle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bundle      get($id, $lockMode = null, $lockVersion = null)
 * @method Bundle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BundleRepository extends ServiceEntityRepository
{
    use GetTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bundle::class);
    }

    public function hasByClass(string $class): bool
    {
        return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.class = :class')
                ->setParameter(':class', $class)
                ->getQuery()->getSingleScalarResult() > 0;
    }

    public function findOneByClass(string $class): ?Bundle
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.class = :val')
            ->setParameter('val', $class)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getOneByClass(string $class): Bundle
    {
        $bundle = $this->findOneByClass($class);

        if (!$bundle) {
            throw new NotFoundException('Bundle not found.');
        }

        return $bundle;
    }
}
