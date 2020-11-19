<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Composer;

use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class RemoveCommand implements CommandInterface
{
    private string $package;

    public function __construct(string $package)
    {
        $this->package = $package;
    }

    public function getPackage(): string
    {
        return $this->package;
    }
}