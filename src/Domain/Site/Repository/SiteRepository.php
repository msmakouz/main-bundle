<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Zentlix\MainBundle\Domain\Shared\Repository\GetTrait;
use Zentlix\MainBundle\Domain\Shared\Repository\MaxSortTrait;
use Zentlix\MainBundle\Domain\Site\Entity\Site;

/**
 * @method Site|null find($id, $lockMode = null, $lockVersion = null)
 * @method Site      get($id, $lockMode = null, $lockVersion = null)
 * @method Site[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteRepository extends ServiceEntityRepository
{
    use GetTrait;
    use MaxSortTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Site::class);
    }

    public function findAll()
    {
        return $this->findBy([], ['sort' => 'asc']);
    }

    public function isSingle(): bool
    {
        return 1 === $this->createQueryBuilder('s')
            ->select('count(site.id)')
            ->from(Site::class, 'site')
            ->getQuery()
            ->getSingleScalarResult() ?: false;
    }

    public function hasByUrl($url): bool
    {
        return $this->createQueryBuilder('t')
                ->select('COUNT(t.id)')
                ->andWhere('t.url = :url')
                ->setParameter(':url', $url)
                ->getQuery()
                ->getSingleScalarResult() > 0;
    }

    public function findAllWithTemplates(): array
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.template', 't')
            ->addSelect('t')
            ->getQuery()
            ->getResult();
    }

    public function assoc(): array
    {
        $sites = $this->createQueryBuilder('a')
            ->select('a.id', 'a.title')
            ->orderBy('a.sort')
            ->getQuery()
            ->execute();

        $result = [];
        foreach ($sites as $site) {
            $result[$site['id']->toRfc4122()] = $site['title'];
        }

        return $result;
    }
}
