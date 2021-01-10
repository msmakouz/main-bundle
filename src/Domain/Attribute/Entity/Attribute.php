<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\Attribute\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping;
use Gedmo\Mapping\Annotation\Slug;
use Zentlix\MainBundle\Application\Command\Attribute\CreateCommand;
use Zentlix\MainBundle\Application\Command\Attribute\UpdateCommand;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Domain\Shared\Entity\Eventable;
use Zentlix\MainBundle\Infrastructure\Share\Doctrine\UuidInterface;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Attribute\Repository\AttributeRepository")
 * @Mapping\Table(name="zentlix_main_attributes")
 */
class Attribute implements Eventable
{
    /**
     * @var UuidInterface
     * @Mapping\Id
     * @Mapping\Column(type="uuid_binary")
     */
    private $id;

    /** @Mapping\Column(type="string", length=255) */
    private $title;

    /**
     * @Slug(fields={"title"}, updatable=false, unique=true, unique_base="entity")
     * @Mapping\Column(type="string", length=64)
     */
    private $code;

    /** @Mapping\Column(type="integer", options={"default": 1}) */
    private $sort;

    /** @Mapping\Column(type="json") */
    private $config;

    /** @Mapping\Column(type="boolean", options={"default": "1"}) */
    private $active;

    /** @Mapping\Column(type="boolean", options={"default": "1"}) */
    private $editable;

    /**
     * @var Bundle
     * @Mapping\ManyToOne(targetEntity="Zentlix\MainBundle\Domain\Bundle\Entity\Bundle")
     * @Mapping\JoinColumn(name="bundle_id", referencedColumnName="id", nullable=false)
     */
    private $bundle;

    /** @Mapping\Column(type="string", length=255) */
    private $entity;

    /** @Mapping\Column(type="string", length=255) */
    private $attribute_type;

    /** @Mapping\OneToMany(targetEntity="Zentlix\MainBundle\Domain\Attribute\Entity\Value", mappedBy="attribute") */
    private $values;

    public function __construct(CreateCommand $command)
    {
        $this->id             = $command->id;
        $this->entity         = $command->attributeEntity;
        $this->bundle         = $command->bundle;
        $this->editable       = $command->editable;
        $this->attribute_type = $command->attribute_type;
        $this->values         = new ArrayCollection();

        $this->setValuesFromCommands($command);
    }

    public function update(UpdateCommand $command)
    {
        $this->setValuesFromCommands($command);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function isEditable(): bool
    {
        return $this->editable;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function isCodeEqual(string $code): bool
    {
        return $code === $this->code;
    }

    public function getAttributeType(): string
    {
        return $this->attribute_type;
    }

    /** @param CreateCommand|UpdateCommand $command */
    private function setValuesFromCommands($command): void
    {
        $this->title  = $command->title;
        $this->code   = $command->code;
        $this->sort   = $command->sort;
        $this->active = $command->active;
        $this->config = $command->config;
    }
}