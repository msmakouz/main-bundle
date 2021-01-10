<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Site\Read;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Collection\Collection;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;
use function is_null;

class SiteFetcher
{
    private string $select = 'NEW Zentlix\MainBundle\Domain\Site\Read\SiteView(s.id, s.title, s.url, s.sort, s.meta,
        l.id, l.code, l.title, l.icon, l.sort, t.id, t.title, t.folder, t.sort)';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByFilter(CollectionFilter $filter, array $orderBy = ['sort' => 'asc', 'title' => 'asc']): Collection
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select($this->select)
            ->from(Site::class, 's')
            ->leftJoin(Locale::class, 'l', Join::WITH, 's.locale = l.id')
            ->leftJoin(Template::class, 't', Join::WITH, 's.template = t.id');

        foreach ($orderBy as $sort => $order) {
            $qb->addOrderBy('s.' . $sort, $order);
        }

        if(count($filter->id) > 0) {
            $qb->andWhere('s.id IN (:ids)');
            $qb->setParameter(':ids', $filter->id);
        }

        if(count($filter->url) > 0) {
            $qb->andWhere('s.url IN (:urls)');
            $qb->setParameter(':urls', $filter->url);
        }

        return new Collection($qb->getQuery()->getResult());
    }

    public function findOneByFilter(Filter $filter): ?SiteView
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select($this->select)
            ->from(Site::class, 's')
            ->leftJoin(Locale::class, 'l', Join::WITH, 's.locale = l.id')
            ->leftJoin(Template::class, 't', Join::WITH, 's.template = t.id');

        if($filter->id) {
            $qb->andWhere('s.id = :id');
            $qb->setParameter(':id', $filter->id);
        }

        if($filter->url) {
            $qb->andWhere('s.url = :url');
            $qb->setParameter(':url', $filter->url);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOneByFilter(Filter $filter): SiteView
    {
        $site = $this->findOneByFilter($filter);

        if(is_null($site)) {
            throw new NotFoundException('Site not found.');
        }

        return $site;
    }

    public function assoc(): array
    {
        $result = [];
        foreach ($this->findByFilter(new CollectionFilter()) as $site) {
            $result[$site->title] = $site->id;
        }

        return $result;
    }
}