<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Attribute;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Attribute\Entity\Attribute;
use Zentlix\MainBundle\Domain\Bundle\Entity\Bundle;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class Command implements CommandInterface
{
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
    protected Attribute $entity;

    public function __get($param)
    {
        if ($this->__isset($param)) {
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

    public function getEntity(): Attribute
    {
        return $this->entity;
    }
}
