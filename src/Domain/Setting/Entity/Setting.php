<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Setting\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Application\Command\Setting\SettingCommandInterface;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Setting\Repository\SettingsRepository")
 * @Mapping\Table(name="zx_main_bundle_settings")
 */
class Setting implements SettingInterface
{
    /**
     * @Mapping\Id()
     * @Mapping\GeneratedValue()
     * @Mapping\Column(type="integer")
     */
    private $id;

    /**
     * @var Locale
     * @Mapping\OneToOne(targetEntity="Zentlix\MainBundle\Domain\Locale\Entity\Locale")
     * @Mapping\JoinColumn(name="locale_id", referencedColumnName="id")
     */
    private $default_locale;

    public function __construct(Locale $defaultLocale)
    {
        $this->default_locale = $defaultLocale;
    }

    public function getDefaultLocale(): Locale
    {
        return $this->default_locale;
    }

    public function change(SettingCommandInterface $command): void
    {
        $this->default_locale = $command->default_locale;
    }
}