<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\DataTable\Service;

use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\Column\AbstractColumn;
use Omines\DataTablesBundle\DataTableFactory as BaseDataTableFactory;
use Omines\DataTablesBundle\DataTableRendererInterface;
use Omines\DataTablesBundle\DependencyInjection\Instantiator;
use Omines\DataTablesBundle\Exporter\DataTableExporterManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Zentlix\MainBundle\Domain\DataTable\Entity\DataTable as DataTableEntity;

class DataTableFactory extends BaseDataTableFactory
{
    public function __construct(
        array $config,
        DataTableRendererInterface $renderer,
        Instantiator $instantiator,
        DataTableExporterManager $dataTableExporter,
        EventDispatcherInterface $eventDispatcher,
        private EntityManagerInterface $entityManager,
        private TokenStorageInterface $tokenStorage
    ) {
        parent::__construct($config, $renderer, $instantiator, $eventDispatcher, $dataTableExporter);
    }

    public function create(array $options = []): DataTable
    {
        $config = $this->config;

        return (
            new DataTable(
                $this->eventDispatcher,
                array_merge($config['options'] ?? [], $options),
                $this->instantiator,
                $this->exporterManager
            ))
            ->setRenderer($this->renderer)
            ->setMethod($config['method'] ?? Request::METHOD_POST)
            ->setPersistState($config['persist_state'] ?? 'fragment')
            ->setTranslationDomain($config['translation_domain'] ?? 'messages')
            ->setLanguageFromCDN($config['language_from_cdn'] ?? true)
            ->setTemplate(
                $config['template'] ?? DataTable::DEFAULT_TEMPLATE,
                $config['template_parameters'] ?? ['className' => 'table table-hover']
            );
    }

    public function createFromType($type, array $typeOptions = [], array $options = []): DataTable
    {
        $dataTable = $this->create($options);

        if (is_string($type)) {
            $name = $type;
            if (isset($this->resolvedTypes[$name])) {
                $type = $this->resolvedTypes[$name];
            } else {
                $this->resolvedTypes[$name] = $type = $this->instantiator->getType($name);
            }
        }

        $type->configure($dataTable, $typeOptions);

        $databaseConfig = $this->getConfig(md5(get_class($type)), $dataTable);

        $dataTable->setDatabaseConfig($databaseConfig);

        return $dataTable;
    }

    private function getConfig(string $class, DataTable $datatable): DataTableEntity
    {
        $dataTableRepository = $this->entityManager->getRepository(DataTableEntity::class);
        $config = $dataTableRepository->getConfig($class, $this->tokenStorage->getToken()->getUser()->getId());

        if (!$config instanceof DataTableEntity) {
            $config = $this->createConfig($class, $datatable);
        }

        return $config;
    }

    private function createConfig(string $class, DataTable $dataTable): DataTableEntity
    {
        $visible = array_diff(
            array_map(
                fn (AbstractColumn $column) => $column->isVisible() ? $column->getName() : null,
                $dataTable->getColumns()
            ),
            [null]
        );

        $config = new DataTableEntity($class, ['visible' => $visible], $this->tokenStorage->getToken()->getUser());

        $this->entityManager->persist($config);
        $this->entityManager->flush();

        return $config;
    }
}
