<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Setting;

use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandHandlerInterface;

class DefaultSettingHandler implements CommandHandlerInterface
{
    public function __invoke(DefaultSettingCommand $command): void
    {
    }
}
