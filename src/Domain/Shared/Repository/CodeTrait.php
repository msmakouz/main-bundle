<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Repository;

use Zentlix\MainBundle\Application\Query\NotFoundException;

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

        if(!$entity) {
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