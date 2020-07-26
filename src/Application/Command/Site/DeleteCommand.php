<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Application\Command\DeleteCommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class DeleteCommand implements DeleteCommandInterface, CommandInterface
{
    /** @Constraints\NotBlank() */
    public Site $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }
}