<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DataTable\Template;

use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Domain\Template\Event\Table as TableEvent;
use Zentlix\MainBundle\Infrastructure\DataTable\AbstractDataTableType;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options): void
    {
        $dataTable->setName('templates-datatable');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => false])
            ->add(
                'title',
                TwigColumn::class,
                [
                    'template' => '@MainBundle/admin/templates/datatable/title.html.twig',
                    'visible' => true,
                    'label' => 'zentlix_main.title',
                ]
            )
            ->add('folder', TextColumn::class, ['label' => 'zentlix_main.directory', 'visible' => true])
            ->add('sort', TextColumn::class, ['label' => 'zentlix_main.sort', 'visible' => true])
            ->addOrderBy($dataTable->getColumnByName('sort'))
            ->createAdapter(ORMAdapter::class, ['entity' => Template::class]);

        $this->eventDispatcher->dispatch(new TableEvent($dataTable));
    }
}
