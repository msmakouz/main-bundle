<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Attribute;

use Symfony\Component\Uid\Uuid;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CreateCommandInterface;
use Zentlix\MainBundle\MainBundle;

class CreateCommand extends Command implements CreateCommandInterface
{
    public function __construct(string $entity)
    {
        $this->id = Uuid::v4();
        $this->attributeEntity = $entity;
        $this->bundle = MainBundle::class;
    }
}
