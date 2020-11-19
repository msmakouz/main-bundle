<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\Bundle;

use Zentlix\MainBundle\Infrastructure\Share\Bus\QueryInterface;

class GetBundleEntityByPackageNameQuery implements QueryInterface
{
    public string $package;

    public function __construct(string $package)
    {
        $this->package = $package;
    }
}