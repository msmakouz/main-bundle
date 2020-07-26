<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Setting;

use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;

class DefaultSettingHandler implements CommandHandlerInterface
{
    public function __invoke(DefaultSettingCommand $command): void {}
}