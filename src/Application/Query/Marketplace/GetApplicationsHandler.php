<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Marketplace;

use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Zentlix\MainBundle\Domain\Marketplace\Service\Applications;
use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryHandlerInterface;

class GetApplicationsHandler implements QueryHandlerInterface
{
    private PaginatorInterface $paginator;
    private Applications $applications;

    public function __construct(PaginatorInterface $paginator, Applications $applications)
    {
        $this->paginator = $paginator;
        $this->applications = $applications;
    }

    public function __invoke(GetApplicationsQuery $query): PaginationInterface
    {
        $pagination = $this->paginator->paginate($this->applications, $query->page,Applications::DEFAULT_LIMIT);
        $pagination->setPaginatorOptions([
            'pageParameterName'          => 'page',
            'sortFieldParameterName'     => 'sort',
            'sortDirectionParameterName' => 'direction',
            'filterFieldParameterName'   => 'category',
            'filterValueParameterName'   => 'filterValue',
            'distinct'                   => true,
            'pageOutOfRange'             => 'ignore',
            'defaultLimit'               => Applications::DEFAULT_LIMIT
        ]);

        return $pagination;
    }
}