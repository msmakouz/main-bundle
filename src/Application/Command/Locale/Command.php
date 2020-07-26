<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Application\Command\DynamicPropertyCommand;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class Command extends DynamicPropertyCommand implements CommandInterface
{
    /** @Constraints\NotBlank() */
    public ?string $title = null;

    /** @Constraints\NotBlank() */
    public ?string $code = null;

    /** @Constraints\NotBlank() */
    public ?int $sort = null;

    public ?string $icon = null;

    protected Locale $entity;

    public function getEntity(): Locale
    {
        return $this->entity;
    }
}