<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Composer;

use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class RequireCommand implements CommandInterface
{
    public string $package;

    public function __construct(string $package)
    {
        $this->package = $package;
    }
}
