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

use Doctrine\ORM\Mapping;

/**
 * @Mapping\Entity(repositoryClass="Zentlix\MainBundle\Domain\Attribute\Repository\ValueRepository")
 * @Mapping\Table(name="zentlix_main_attribute_values")
 */
class Value
{
    /**
     * @Mapping\Id
     * @Mapping\Column(type="uuid", unique=true)
     */
    private $id;

    /** @Mapping\Column(type="text", nullable=false) */
    private $value;

    /** @Mapping\Column(type="string", length=255) */
    private $entity_id;

    /**
     * @var Attribute
     * @Mapping\ManyToOne(targetEntity="Zentlix\MainBundle\Domain\Attribute\Entity\Attribute", inversedBy="values")
     * @Mapping\JoinColumn(name="attribute_id", referencedColumnName="id", nullable=false)
     */
    private $attribute;

    public function __construct($id, $value, $entityId, Attribute $attribute)
    {
        $this->id        = $id;
        $this->value     = $value;
        $this->entity_id = $entityId;
        $this->attribute = $attribute;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getEntityId()
    {
        return $this->entity_id;
    }

    public function getAttribute(): Attribute
    {
        return $this->attribute;
    }

    public function changeValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function isValueEqual($value): bool
    {
        return $this->value === $value;
    }
}