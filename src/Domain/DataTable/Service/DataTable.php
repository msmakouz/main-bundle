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

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Omines\DataTablesBundle\DependencyInjection\Instantiator;
use Omines\DataTablesBundle\Column\AbstractColumn;
use Omines\DataTablesBundle\DataTable as BaseDataTable;
use Omines\DataTablesBundle\Exception\InvalidStateException;
use Zentlix\MainBundle\Domain\DataTable\Column\TextColumn;
use Zentlix\MainBundle\Domain\DataTable\Entity\DataTable as DataTableEntity;
use Zentlix\UserBundle\Domain\User\Entity\User;

class DataTable extends BaseDataTable
{
    private EntityManagerInterface $entityManager;
    private TokenStorageInterface $tokenStorage;
    protected string $createUrl;
    protected string $title;
    protected array $token = [];
    protected ?string $createBtnLabel = null;
    protected $method = Request::METHOD_GET;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                array $options,
                                Instantiator $instantiator,
                                EntityManagerInterface $entityManager,
                                TokenStorageInterface $tokenStorage)
    {
        $this->entityManager = $entityManager;
        $this->tokenStorage = $tokenStorage;

        parent::__construct($eventDispatcher, $options, $instantiator);
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function setCreateUrl(string $createUrl): self
    {
        $this->createUrl = $createUrl;

        return $this;
    }

    public function setCsrfToken(string $name, string $token): self
    {
        $this->token[$name] = $token;

        return $this;
    }

    public function setCreateBtnLabel(string $createBtnLabel): self
    {
        $this->createBtnLabel = $createBtnLabel;

        return $this;
    }

    public function getCreateUrl(): string
    {
        if(!empty($this->createUrl)) {
            return $this->createUrl;
        }

        return str_replace('list', '', $this->name) . 'create';
    }

    public function getCreateBtnLabel(): ?string
    {
        return $this->createBtnLabel;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCsrfToken(): ?array
    {
        return $this->token;
    }

    public function getResponse(): JsonResponse
    {
        if (null === $this->getState()) {
            throw new InvalidStateException('The DataTable does not know its state yet, did you call handleRequest?');
        }

        $resultSet = $this->getResultSet();

        if ($this->getState()->isInitial()) {
            $response['options'] = $this->getInitialResponse();
            $response['resource'] = $this->getName();
            $response['title'] = $this->getTitle();
            $response['recordsTotal'] = $resultSet->getTotalRecords();
            $response['createBtnLabel'] = $this->getCreateBtnLabel();
            $response['createUrl'] = $this->getCreateUrl();
            $response['token'] = $this->getCsrfToken();
        } else {
            $response = iterator_to_array($resultSet->getData());
        }

        return JsonResponse::create($response);
    }

    protected function getInitialResponse(): array
    {
        $config = $this->getConfig();
        return array_merge($this->getOptions(), [
            'columns' => array_map(
                fn (AbstractColumn $column) =>
                [
                    'data' => $column->getName(),
                    'orderable' => $column->isOrderable(),
                    'searchable' => $column->isSearchable(),
                    'visible' => $config->isVisible($column->getName()),
                    'className' => $column->getClassName(),
                    'title' => $column->getLabel(),
                    'translate' => $column instanceof TextColumn ? $column->isNeedTranslate() : false
                ], $this->getColumns()
            ),
        ]);
    }

    public function handleRequest(Request $request): BaseDataTable
    {
        $this->setMethod(Request::METHOD_GET);

        return parent::handleRequest($request);
    }

    private function getConfig(): DataTableEntity
    {
        $dataTableRepository = $this->entityManager->getRepository(DataTableEntity::class);
        $config = $dataTableRepository->getConfig($this->name, $this->tokenStorage->getToken()->getUser()->getId());

        if(!$config instanceof DataTableEntity) {
            $config = $this->createConfig();
        }

        return $config;
    }

    private function createConfig(): DataTableEntity
    {
        $visible = array_diff(array_map(fn (AbstractColumn $column) => $column->isVisible() ? $column->getName() : null, $this->getColumns()), [null]);
        $userRepository = $this->entityManager->getRepository(User::class);

        $config = new DataTableEntity($this->name, ['visible' => $visible], $userRepository->get($this->tokenStorage->getToken()->getUser()->getId()));

        $this->entityManager->persist($config);
        $this->entityManager->flush();

        return $config;
    }
}