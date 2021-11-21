<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DataTable\Locale;

use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Locale\Event\Table as TableEvent;
use Zentlix\MainBundle\Infrastructure\DataTable\AbstractDataTableType;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options): void
    {
        $dataTable->setName('locales-datatable');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => false])
            ->add(
                'title',
                TwigColumn::class,
                [
                    'template' => '@MainBundle/admin/locales/datatable/title.html.twig',
                    'visible' => true,
                    'label' => 'zentlix_main.title',
                ]
            )
            ->add('code', TextColumn::class, ['label' => 'zentlix_main.code', 'visible' => true])
            ->add('sort', TextColumn::class, ['label' => 'zentlix_main.sort', 'visible' => true])
            ->addOrderBy($dataTable->getColumnByName('sort'), $dataTable::SORT_ASCENDING)
            ->addOrderBy($dataTable->getColumnByName('title'), $dataTable::SORT_ASCENDING)
            ->createAdapter(ORMAdapter::class, ['entity' => Locale::class]);

        $this->eventDispatcher->dispatch(new TableEvent($dataTable));
    }
}
