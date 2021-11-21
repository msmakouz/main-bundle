<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Marketplace;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Zentlix\MainBundle\Domain\Marketplace\Service\Applications;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetApplicationsHandler implements QueryHandlerInterface
{
    public function __construct(
        private PaginatorInterface $paginator,
        private Applications $applications
    ) {
    }

    public function __invoke(GetApplicationsQuery $query): PaginationInterface
    {
        $pagination = $this->paginator->paginate($this->applications, $query->page, Applications::DEFAULT_LIMIT);
        $pagination->setPaginatorOptions([
            'pageParameterName' => 'page',
            'sortFieldParameterName' => 'sort',
            'sortDirectionParameterName' => 'direction',
            'filterFieldParameterName' => 'category',
            'filterValueParameterName' => 'filterValue',
            'distinct' => true,
            'pageOutOfRange' => 'ignore',
            'defaultLimit' => Applications::DEFAULT_LIMIT,
        ]);

        return $pagination;
    }
}
