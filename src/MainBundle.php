<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle;

use Zentlix\MainBundle\Application;
use Zentlix\MainBundle\Domain\Setting\Entity\Setting;
use Zentlix\MainBundle\UI\Http\Web\Form\Setting\Form;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class MainBundle extends Bundle implements ZentlixBundleInterface
{
    use ZentlixBundleTrait;

    public function getVersion(): string
    {
        return '0.4.0';
    }

    public function getTitle(): string
    {
        return 'zentlix_main.main_bundle';
    }

    public function getDeveloper(): array
    {
        return ['name' => 'Zentlix', 'url' => 'https://zentlix.io'];
    }

    public function getDescription(): string
    {
        return 'zentlix_main.main_bundle_description';
    }

    public function configureRights(): array
    {
        return [
            Application\Query\Site\DataTableQuery::class          => 'zentlix_main.site.view',
            Application\Command\Site\CreateCommand::class         => 'zentlix_main.site.create.process',
            Application\Command\Site\UpdateCommand::class         => 'zentlix_main.site.update.process',
            Application\Command\Site\DeleteCommand::class         => 'zentlix_main.site.delete.process',
            Application\Query\Bundle\DataTableQuery::class        => 'zentlix_main.bundle.view',
            Application\Command\VisualEditor\EnableCommand::class => 'zentlix_main.visual_editor'
        ];
    }

    public function getSettingsClass(): string
    {
        return Setting::class;
    }

    public function getSettingsForm(): string
    {
        return Form::class;
    }

    public function isSystem(): bool
    {
        return true;
    }
}