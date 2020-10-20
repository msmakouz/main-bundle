<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Service;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Omines\DataTablesBundle\DependencyInjection\Instantiator;
use Omines\DataTablesBundle\Column\AbstractColumn;
use Omines\DataTablesBundle\DataTable as BaseDataTable;
use Zentlix\MainBundle\Domain\DataTable\Entity\DataTable as DataTableConfig;

class DataTable extends BaseDataTable
{
    protected $method = Request::METHOD_GET;
    protected DataTableConfig $config;

    public function __construct(EventDispatcherInterface $eventDispatcher, array $options, Instantiator $instantiator)
    {
        // override options
        $options['searching'] = true;
        $options['pagingType'] = 'simple_numbers';
        $options['dom'] = "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>";
        $options['pageLength'] = 25;
        $options['lengthMenu'] = [[10, 25, 50, 100, 200], [10, 25, 50, 100, 200]];

        parent::__construct($eventDispatcher, $options, $instantiator);
    }

    public function setDatabaseConfig(DataTableConfig $config)
    {
        $this->config = $config;
    }

    protected function getInitialResponse(): array
    {
        return array_merge($this->getOptions(), [
            'columns' => array_map(
                function (AbstractColumn $column) {
                    return [
                        'data'       => $column->getName(),
                        'orderable'  => $column->isOrderable(),
                        'searchable' => $column->isSearchable(),
                        'visible'    => $this->config->isVisible($column->getName()),
                        'className'  => $column->getClassName(),
                    ];
                }, $this->getColumns()
            ),
        ]);
    }

    public function handleRequest(Request $request): BaseDataTable
    {
        $this->setMethod(Request::METHOD_GET);

        return parent::handleRequest($request);
    }
}