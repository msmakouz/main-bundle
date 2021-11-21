<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Shared\Repository;

trait MaxSortTrait
{
    public function getMaxSort()
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('MAX(u.sort) as sort');

        return $qb->getQuery()->getSingleResult()['sort'] ?? 0;
    }
}
