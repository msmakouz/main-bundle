<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle\Zentlix;

use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class RemoveCommand implements CommandInterface
{
    public function __construct(
        private Bundle $bundle
    ) {
    }

    public function getBundle(): Bundle
    {
        return $this->bundle;
    }
}
