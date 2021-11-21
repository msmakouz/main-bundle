<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Bundle\Entity;

use Doctrine\ORM\Mapping;
use Zentlix\MainBundle\Application\Command\Bundle\Zentlix\InstallCommand;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository")
 * @Mapping\Table(name="zentlix_main_bundles", uniqueConstraints={
 *     @Mapping\UniqueConstraint(columns={"class"})
 * })
 */
class Bundle
{
    /**
     * @Mapping\Id
     * @Mapping\Column(type="uuid", unique=true)
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $title;

    /** @Mapping\Column(type="string", length=255, unique=true) */
    private $class;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $description;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $settings_form;

    /** @Mapping\Column(type="string", length=255, nullable=true) */
    private $settings_entity;

    /** @Mapping\Column(type="string", length=255) */
    private $version;

    /**
     * @var \DateTimeImmutable
     * @Mapping\Column(type="datetime_immutable")
     */
    private $updated_at;

    /**
     * @var \DateTimeImmutable
     * @Mapping\Column(type="datetime_immutable")
     */
    private $installed_at;

    /** @Mapping\Column(type="boolean", options={"default": "0"}) */
    private $system_bundle;

    public function __construct(InstallCommand $command)
    {
        $this->id = $command->id;
        $this->title = $command->getBundle()->getTitle();
        $this->class = $command->getBundle()::class;
        $this->description = $command->getBundle()->getDescription();
        $this->version = $command->getBundle()->getVersion();
        $this->system_bundle = $command->getBundle()->isSystem();
        $this->settings_form = $command->getBundle()->getSettingsForm();
        $this->settings_entity = $command->getBundle()->getSettingsClass();
        $this->updated_at = $command->updated_at;
        $this->installed_at = $command->installed_at;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getInstalledAt(): \DateTimeImmutable
    {
        return $this->installed_at;
    }

    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function isSystem(): bool
    {
        return $this->system_bundle;
    }

    public function getSettingsForm(): ?string
    {
        return $this->settings_form;
    }

    public function getSettingsEntity(): ?string
    {
        return $this->settings_entity;
    }
}
