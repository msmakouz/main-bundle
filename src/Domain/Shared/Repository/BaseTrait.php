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

trait BaseTrait
{
    public function findBase(int $siteId): array
    {
        $entities = $this->findAll();

        $bases = [];
        foreach ($entities as $entity) {
            if($entity->isBaseForSite($siteId)) {
                $bases[] = $entity;
            }
        }

        return $bases;
    }

    public function disableBase(array $baseSites): void
    {
        foreach ($baseSites as $baseSite) {
            $currentBases = $this->findBase($baseSite);
            foreach ($currentBases as $base) {
                $base->disableBase($baseSites);
            }
        }
    }

    public function isBase(int $id): ?bool
    {
        return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.base_for_site > 0')
                ->andWhere('t.id = :val')
                ->setParameter(':val', $id)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }
}