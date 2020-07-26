<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DataTable\Locale;

use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\DataTable;
use Zentlix\MainBundle\Infrastructure\Share\DataTable\AbstractDataTableType;
use Zentlix\MainBundle\Domain\Locale\Event\Table as TableEvent;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable->setName($this->router->generate('admin.locale.list'));
        $dataTable->setTitle('zentlix_main.locale.locales');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => true,])
            ->add('title', TextColumn::class,
                [
                    'render' => fn($value, Locale $context) =>
                        sprintf('<a href="%s">%s</a>', $this->router->generate('admin.locale.update', ['id' => $context->getId()]), $value),
                    'visible' => true,
                    'label' => 'zentlix_main.title'
                ])
            ->add('code', TextColumn::class, ['label' => 'zentlix_main.code', 'visible' => true])
            ->add('sort', TextColumn::class, ['label' => 'zentlix_main.sort', 'visible' => true])
            ->addOrderBy($dataTable->getColumnByName('sort'), $dataTable::SORT_ASCENDING)
            ->addOrderBy($dataTable->getColumnByName('id'), $dataTable::SORT_DESCENDING)
            ->createAdapter(ORMAdapter::class, ['entity' => Locale::class]);

        $this->eventDispatcher->dispatch(new TableEvent($dataTable));
    }
}