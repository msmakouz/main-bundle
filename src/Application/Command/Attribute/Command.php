<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Attribute;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class Command implements CommandInterface
{
    protected Attribute $entity;

    public $id;
    public array $config = [];
    public ?string $title = null;
    public ?string $code = null;
    public bool $active = true;
    public bool $editable = true;
    /** @var string|Bundle */
    public $bundle;
    public string $attributeEntity;
    /** @Constraints\NotBlank() */
    public int $sort = 0;
    public ?string $attribute_type = null;


    public function getEntity(): Attribute
    {
        return $this->entity;
    }

    public function __get($param)
    {
        if($this->__isset($param)) {
            return $this->config[$param];
        }

        return null;
    }

    public function __set($param, $value): void
    {
        $this->config[$param] = $value;
    }

    public function __isset($param): bool
    {
        return isset($this->config[$param]);
    }
}