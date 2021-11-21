<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Template\Read;

use Doctrine\ORM\EntityManagerInterface;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Collection\Collection;
use Zentlix\MainBundle\Infrastructure\Share\Bus\NotFoundException;

class TemplateFetcher
{
    private string $select =
        'NEW Zentlix\MainBundle\Domain\Template\Read\TemplateView(t.id, t.title, t.folder, t.sort)';

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
            ->from(Template::class, 't');

        foreach ($orderBy as $sort => $order) {
            $qb->addOrderBy('t.' . $sort, $order);
        }

        if (count($filter->id) > 0) {
            $qb->andWhere('t.id IN (:ids)');
            $qb->setParameter(':ids', $filter->id);
        }

        return new Collection($qb->getQuery()->getResult());
    }

    public function findOneByFilter(Filter $filter): ?TemplateView
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select($this->select)
            ->from(Template::class, 't');

        if ($filter->id) {
            $qb->andWhere('t.id = :id');
            $qb->setParameter(':id', $filter->id);
        }

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getOneByFilter(Filter $filter): TemplateView
    {
        $template = $this->findOneByFilter($filter);

        if (\is_null($template)) {
            throw new NotFoundException('Template not found.');
        }

        return $template;
    }

    public function assoc(): array
    {
        $result = [];
        foreach ($this->findByFilter(new CollectionFilter()) as $template) {
            $result[$template->title] = $template->id;
        }

        return $result;
    }
}
