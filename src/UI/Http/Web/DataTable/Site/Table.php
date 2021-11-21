<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DataTable\Site;

use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Site\Event\Table as TableEvent;
use Zentlix\MainBundle\Infrastructure\DataTable\AbstractDataTableType;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options): void
    {
        $dataTable->setName('sites-datatable');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => false])
            ->add(
                'title',
                TwigColumn::class,
                [
                    'template' => '@MainBundle/admin/sites/datatable/title.html.twig',
                    'visible' => true,
                    'label' => 'zentlix_main.title',
                ]
            )

            ->add('url', TextColumn::class, ['label' => 'zentlix_main.site.url', 'visible' => true])
            ->add('template', TextColumn::class, [
                'data' => fn (Site $site) => $site->getTemplate()->getTitle(),
                'label' => 'zentlix_main.template.template',
                'visible' => true,
                'orderable' => false,
            ])
            ->add('sort', TextColumn::class, ['label' => 'zentlix_main.sort', 'visible' => true])
            ->add('locale', TextColumn::class, ['label' => 'zentlix_main.localisation', 'visible' => false])
            ->addOrderBy($dataTable->getColumnByName('sort'))
            ->createAdapter(ORMAdapter::class, ['entity' => Site::class]);

        $this->eventDispatcher->dispatch(new TableEvent($dataTable));
    }
}
