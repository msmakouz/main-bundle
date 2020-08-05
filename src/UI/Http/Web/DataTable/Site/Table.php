<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DataTable\Site;

use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Zentlix\MainBundle\Infrastructure\Share\DataTable\AbstractDataTableType;
use Zentlix\MainBundle\Domain\Site\Event\Site\Table as TableEvent;
use Zentlix\MainBundle\Domain\Site\Entity\Site;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable->setName($this->router->generate('admin.site.list'));
        $dataTable->setTitle('zentlix_main.site.sites');
        $dataTable->setCreateBtnLabel('zentlix_main.site.create.action');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => true])
            ->add('title', TextColumn::class,
                [
                    'render' => fn($value, Site $context) =>
                        sprintf('<a href="%s">%s</a>', $this->router->generate('admin.site.update', ['id' => $context->getId()]), $value),
                    'visible' => true,
                    'label' => 'zentlix_main.title'
                ])

            ->add('url', TextColumn::class, ['label' => 'zentlix_main.site.url', 'visible' => true])
            ->add('template', TextColumn::class, [
                'data' => fn (Site $site) => $site->getTemplate()->getTitle(),
                'label' => 'zentlix_main.template',
                'visible' => true,
                'orderable' => false
            ])
            ->add('sort', TextColumn::class, ['label' => 'zentlix_main.sort', 'visible' => true])
            ->add('locale', TextColumn::class, ['label' => 'zentlix_main.localisation', 'visible' => false])
            ->addOrderBy($dataTable->getColumnByName('sort'))
            ->createAdapter(ORMAdapter::class, ['entity' => Site::class]);

        $this->eventDispatcher->dispatch(new TableEvent($dataTable));
    }
}