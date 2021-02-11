<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\DataTable\Bundle;

use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Zentlix\MainBundle\Infrastructure\DataTable\AbstractDataTableType;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable->setName('bundles-datatable');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => false])
            ->add('title', TwigColumn::class,
                [
                    'template'  => '@MainBundle/admin/bundles/datatable/title.html.twig',
                    'visible'   => true,
                    'orderable' => false,
                    'label'     => 'zentlix_main.title'
                ])
            ->add('version', TextColumn::class, [
                'label'     => 'zentlix_main.version',
                'visible'   => true,
                'orderable' => false
            ])
            ->add('updated_at', DateTimeColumn::class, [
                'label'  => 'zentlix_main.bundle.updated',
                'format' => 'd-m-Y H:i:s', 'visible' => true,
                'searchable' => false
            ])
            ->add('installed_at', DateTimeColumn::class, [
                'label'      => 'zentlix_main.bundle.installed_at',
                'format'     => 'd-m-Y H:i:s',
                'visible'    => true,
                'searchable' => false
            ])
            ->add('system_bundle', TwigColumn::class,
                [
                    'template'   => '@MainBundle/admin/bundles/datatable/action.html.twig',
                    'label'      => 'zentlix_main.action',
                    'visible'    => true,
                    'orderable'  => true,
                    'searchable' => false
                ])
            ->addOrderBy($dataTable->getColumnByName('system_bundle'), $dataTable::SORT_DESCENDING)
            ->addOrderBy($dataTable->getColumnByName('id'), $dataTable::SORT_DESCENDING)
            ->createAdapter(ORMAdapter::class, [
                'entity' => Bundle::class,
                'query' => fn (QueryBuilder $builder) => $builder->select('bundle')->from(Bundle::class, 'bundle')
            ]);
    }
}