<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Event;

use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;

final class AfterInstall
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
