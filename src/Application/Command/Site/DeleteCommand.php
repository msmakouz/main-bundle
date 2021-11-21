<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\DeleteCommandInterface;

class DeleteCommand implements DeleteCommandInterface, CommandInterface
{
    /** @Constraints\NotBlank() */
    public Site $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }
}
