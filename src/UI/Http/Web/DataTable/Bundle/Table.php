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

use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Zentlix\MainBundle\Infrastructure\Share\DataTable\AbstractDataTableType;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;

class Table extends AbstractDataTableType
{
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable->setCsrfToken('uninstall_form', $this->tokenManager->getToken('uninstall_form')->getValue());

        $dataTable->setName($this->router->generate('admin.bundle.list'));
        $dataTable->setTitle('zentlix_main.bundle.bundles');

        $dataTable
            ->add('id', TextColumn::class, ['label' => 'ID', 'visible' => true])
            ->add('title', TextColumn::class,
                [
                    'render' => fn($value, Bundle $bundle) =>
                         sprintf('<a href="%s" title="' . $this->translator->trans('zentlix_main.bundle.settings') . '">%s',
                             $this->router->generate('admin.bundle.update', [
                                 'id' => $bundle->getId()]), $this->translator->trans($bundle->getTitle())) .
                               '<br><small>' . $this->translator->trans($bundle->getDescription()) . '</small></a>',
                    'visible' => true,
                    'orderable' => false,
                    'label' => 'zentlix_main.title'
                ])
            ->add('version', TextColumn::class, [
                'label' => 'zentlix_main.version',
                'visible' => true,
                'orderable' => false
            ])
            ->add('updated_at', DateTimeColumn::class, [
                'label' => 'zentlix_main.bundle.updated',
                'format' => 'd-m-Y H:i:s', 'visible' => true
            ])
            ->add('installed_at', DateTimeColumn::class, [
                'label' => 'zentlix_main.bundle.installed_at',
                'format' => 'd-m-Y H:i:s',
                'visible' => true
            ])
            ->add('system_bundle', TextColumn::class,
                [
                    'label' => 'System',
                    'visible' => false, // system field, always hidden
                    'orderable' => false,
                    'data' => fn(Bundle $bundle) => $bundle->isSystem() ?
                        $this->translator->trans('zentlix_main.yes') : $this->translator->trans('zentlix_main.no')
                ])
            ->addOrderBy($dataTable->getColumnByName('system_bundle'), $dataTable::SORT_DESCENDING)
            ->addOrderBy($dataTable->getColumnByName('id'), $dataTable::SORT_DESCENDING)
            ->createAdapter(ORMAdapter::class, ['entity' => Bundle::class]);
    }
}