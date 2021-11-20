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

use Symfony\Component\Uid\Uuid;
use Zentlix\MainBundle\Domain\Shared\ValueObject\Meta;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CreateCommandInterface;

class CreateCommand extends Command implements CreateCommandInterface
{
    public function __construct()
    {
        $this->id   = Uuid::v4();
        $this->meta = new Meta();
    }
}