<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class Command implements CommandInterface
{
    public $id;

    /** @Constraints\NotBlank() */
    public ?string $title = null;

    /** @Constraints\NotBlank() */
    public ?string $code = null;

    /** @Constraints\NotBlank() */
    public int $sort = 1;

    public ?string $icon = null;
    public array $attributes = [];

    protected Locale $entity;

    public function getEntity(): Locale
    {
        return $this->entity;
    }
}
