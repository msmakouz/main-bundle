<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Application\Command\DynamicPropertyCommand;
use Zentlix\MainBundle\Application\Command\MetaTrait;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Site\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;

class Command extends DynamicPropertyCommand implements CommandInterface
{
    use MetaTrait;

    /** @Constraints\NotBlank() */
    public ?string $title = null;

    /** @Constraints\NotBlank() */
    public ?string $url = null;

    /**
     * @var int|Locale
     * @Constraints\NotBlank()
     */
    public $locale;

    /**
     * @var int|Template
     * @Constraints\NotBlank()
     */
    public $template;

    public ?int $sort = null;
    protected ?Site $entity = null;

    public function getEntity(): Site
    {
        return $this->entity;
    }
}