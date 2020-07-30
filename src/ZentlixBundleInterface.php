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

use Zentlix\UserBundle\Domain\Mailer\Entity\Event;

interface ZentlixBundleInterface {

    public function getTitle():string;
    public function getVersion(): string;
    public function getDescription(): string;
    public function getDeveloper(): array;
    public function configureRights(): array;
    public function getSettingsClass(): ?string;
    public function getSettingsForm(): ?string;
    public function installFrontendRoutes(): array;
    /** @return Event[] */
    public function installMailerEvents(): array;
    public function getBundleName(): string;
    public function isSystem(): bool;
}