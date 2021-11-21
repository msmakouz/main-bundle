<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Locale\Read;

use Doctrine\ORM\EntityManagerInterface;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Infrastructure\Collection\Collection;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

class LocaleFetcher
{
    private string $select =
        'NEW Zentlix\MainBundle\Domain\Locale\Read\LocaleView(l.id, l.code, l.title, l.icon, l.sort)';

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByFilter(
        CollectionFilter $filter,
        array $orderBy = ['sort' => 'asc', 'title' => 'asc']
    ): Collection {
        $qb = $this->entityManager->createQueryBuilder()
            ->select($this->select)
            ->from(Locale::class, 'l');

        foreach ($orderBy as $sort => $order) {
            $qb->addOrderBy('l.' . $sort, $order);
        }

        if (count($filter->id) > 0) {
            $qb->andWhere('l.id IN (:ids)');
            $qb->setParameter(':ids', $filter->id);
        }

        if (count($filter->code) > 0) {
            $qb->andWhere('l.code IN (:codes)');
            $qb->setParameter(':codes', $filter->code);
        }

        return new Collection($qb->getQuery()->getResult());
    }

    public function findOneByFilter(Filter $filter): ?LocaleView
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select($this->select)
            ->from(Locale::class, 'l');

        if ($filter->id) {
            $qb->andWhere('l.id = :id');
            $qb->setParameter(':id', $filter->id);
        }

        if ($filter->code) {
            $qb->andWhere('l.code = :code');
            $qb->setParameter(':code', $filter->code);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOneByFilter(Filter $filter): LocaleView
    {
        $locale = $this->findOneByFilter($filter);

        if (\is_null($locale)) {
            throw new NotFoundException('Locale not found.');
        }

        return $locale;
    }

    public function assoc(): array
    {
        $result = [];
        foreach ($this->findByFilter(new CollectionFilter()) as $locale) {
            $result[$locale->title] = $locale->id;
        }

        return $result;
    }
}
