<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\Attribute\Entity\Value;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;

/**
 * @method Value get($id, $lockMode = null, $lockVersion = null)
 * @method Value|null find($id, $lockMode = null, $lockVersion = null)
 * @method Value|null findOneBy(array $criteria, array $orderBy = null)
 * @method Value[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ValueRepository extends ServiceEntityRepository
{
    use GetTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Value::class);
    }

    public function findByAttributeAndEntity($attributeId, $entityId, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->findBy(['attribute' => $attributeId, 'entity_id' => $entityId], $orderBy, $limit, $offset);
    }

    public function findOneByAttributeAndEntity($attributeId, $entityId, array $orderBy = null): ?Value
    {
        return $this->findOneBy(['attribute' => $attributeId, 'entity_id' => $entityId], $orderBy);
    }

    public function findByEntityId($entityId, array $orderBy = null, $limit = null, $offset = null): array
    {
        return $this->findBy(['entity_id' => $entityId], $orderBy, $limit, $offset);
    }
}