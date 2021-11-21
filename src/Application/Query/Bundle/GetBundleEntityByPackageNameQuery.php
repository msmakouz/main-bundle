<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Bundle;

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class GetBundleEntityByPackageNameQuery implements QueryInterface
{
    public function __construct(
        public string $package
    ) {
    }
}
