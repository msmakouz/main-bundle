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

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Application\Command\DynamicPropertyCommand;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;
use Zentlix\MainBundle\Domain\Setting\Entity\SettingInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class SettingCommand extends DynamicPropertyCommand implements CommandInterface, SettingCommandInterface
{
    /**
     * @var int|Locale
     * @Constraints\NotBlank()
     */
    public $default_locale;

    private Setting $setting;

    public function __construct(Setting $setting)
    {
        $this->setting = $setting;

        $this->default_locale = $setting->getDefaultLocale()->getId();
    }

    public function getSettings(): SettingInterface
    {
        return $this->setting;
    }
}