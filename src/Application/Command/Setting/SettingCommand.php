<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Setting;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;
use Zentlix\MainBundle\Domain\Setting\Entity\SettingInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\DynamicPropertyCommand;

class SettingCommand extends DynamicPropertyCommand implements CommandInterface, SettingCommandInterface
{
    /** @Constraints\NotBlank() */
    public string|Locale $default_locale;

    private Setting $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;
        $this->default_locale = $setting->getDefaultLocale()->getId()->toRfc4122();
    }

    public function getSettings(): SettingInterface
    {
        return $this->setting;
    }
}
