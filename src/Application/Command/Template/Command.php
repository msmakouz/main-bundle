<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Template;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class Command implements CommandInterface
{
    public $id;

    /** @Constraints\NotBlank() */
    public ?string $title = null;

    /** @Constraints\NotBlank() */
    public ?string $folder = null;

    /** @Constraints\NotBlank() */
    public int $sort = 1;
    public array $attributes = [];

    protected Template $entity;

    public function getEntity(): Template
    {
        return $this->entity;
    }
}
