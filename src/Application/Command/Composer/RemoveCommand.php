<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Composer;

use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class RemoveCommand implements CommandInterface
{
    private Bundle $bundle;

    public function __construct(Bundle $bundle)
    {
        $this->bundle = $bundle;
    }

    public function getBundle(): Bundle
    {
        return $this->bundle;
    }
}