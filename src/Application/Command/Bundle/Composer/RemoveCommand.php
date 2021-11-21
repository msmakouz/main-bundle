<?php

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
