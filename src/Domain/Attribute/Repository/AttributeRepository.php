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
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Shared\Repository\CodeTrait;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;

/**
 * @method Attribute get($id, $lockMode = null, $lockVersion = null)
 * @method Attribute getOneByCode(string $code)
 * @method Attribute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attribute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attribute|null findOneByCode(string $code)
 * @method Attribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributeRepository extends ServiceEntityRepository
{
    use GetTrait, CodeTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attribute::class);
    }

    public function findAll()
    {
        return $this->findBy([], ['sort' => 'ASC']);
    }

    public function findEditableByEntity(string $entity, array $orderBy = ['sort' => 'ASC'], $limit = null, $offset = null): array
    {
        return $this->findBy(['entity' => $entity, 'editable' => 1], $orderBy, $limit, $offset);
    }

    public function findActiveByEntity(string $entity, array $orderBy = ['sort' => 'ASC'], $limit = null, $offset = null): array
    {
        return $this->findBy(['entity' => $entity, 'active' => 1], $orderBy, $limit, $offset);
    }

    public function getMaxSort(string $entity): int
    {
        $sort = $this->createQueryBuilder('e')
            ->select('MAX(e.sort) as sort')
            ->andWhere('e.entity = :entity')
            ->setParameter(':entity', $entity)
            ->getQuery()
            ->getSingleResult()['sort'];

        return $sort ? (int) $sort : 0;
    }
}