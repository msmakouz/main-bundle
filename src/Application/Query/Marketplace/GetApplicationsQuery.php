<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Marketplace;

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class GetApplicationsQuery implements QueryInterface
{
    public function __construct(
        public int $page
    ) {
    }
}
