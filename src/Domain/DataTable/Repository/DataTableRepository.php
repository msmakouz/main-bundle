<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\DataTable\Entity\DataTable;

/**
 * @method DataTable|null find($id, $lockMode = null, $lockVersion = null)
 * @method DataTable|null findOneBy(array $criteria, array $orderBy = null)
 * @method DataTable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataTableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DataTable::class);
    }

    public function getConfig(string $dataTable, int $userId)
    {
        return $this->findOneBy(['datatable' => $dataTable, 'user' => $userId]);
    }

    public function findByUserId(int $userId)
    {
        return $this->findBy(['user' => $userId]);
    }
}