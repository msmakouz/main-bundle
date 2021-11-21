<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Repository;

use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

trait CodeTrait
{
    public function findOneByCode(string $code)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.code = :val')
            ->setParameter('val', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByCode($code, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->findBy(['code' => $code], $orderBy, $limit, $offset);
    }

    public function getOneByCode(string $code)
    {
        $entity = $this->findOneByCode($code);

        if (!$entity) {
            throw new NotFoundException('Entity not found.');
        }

        return $entity;
    }

    public function hasByCode(string $code): bool
    {
        return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.code = :val')
                ->setParameter('val', $code)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }
}
