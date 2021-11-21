<?php

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

    public function getConfig(string $dataTable, $userId)
    {
        return $this->findOneBy(['datatable' => $dataTable, 'user' => $userId]);
    }

    public function findByUserId($userId)
    {
        return $this->findBy(['user' => $userId]);
    }
}
