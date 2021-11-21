<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Symfony\Component\Uid\Uuid;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CreateCommandInterface;

class CreateCommand extends Command implements CreateCommandInterface
{
    public function __construct()
    {
        $this->id = Uuid::v4();
    }
}
