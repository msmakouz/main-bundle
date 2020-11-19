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

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class GetApplicationsQuery implements QueryInterface
{
    public int $page;

    public function __construct(int $page)
    {
        $this->page = $page;
    }
}