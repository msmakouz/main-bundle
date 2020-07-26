<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\ZentlixBundleInterface;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;

class InstallCommand
{
    public string $title;
    /** @Constraints\NotBlank() */
    private string $class;
    public string $description;
    public string $version;
    public bool $system = false;
    public \DateTimeImmutable $updated_at;
    public \DateTimeImmutable $installed_at;
    private Bundles $bundles;

    public function __construct(Bundles $bundles)
    {
        $this->updated_at = new \DateTimeImmutable();
        $this->installed_at = new \DateTimeImmutable();
        $this->bundles = $bundles;
    }

    public function setBundle(ZentlixBundleInterface $bundle): void
    {
        $this->title = $bundle->getTitle();
        $this->description = $bundle->getDescription();
        $this->version = $bundle->getVersion();
    }

    public function setClass(string $class): void
    {
        $this->class = $class;

        $this->setBundle($this->bundles->getByClass($class));
    }

    public function getClass(): ?string
    {
        return $this->class;
    }
}