<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Symfony\Component\Validator\Constraints;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Share\Bus\CommandInterface;
use Zentlix\MainBundle\Infrastructure\Share\Bus\MetaTrait;

class Command implements CommandInterface
{
    use MetaTrait;

    public $id;

    /** @Constraints\NotBlank() */
    public ?string $title = null;

    /** @Constraints\NotBlank() */
    public ?string $url = null;

    /**
     * @var string|Locale
     * @Constraints\NotBlank()
     */
    public $locale;

    /**
     * @var string|Template
     * @Constraints\NotBlank()
     */
    public $template;

    public int $sort = 1;
    public array $attributes = [];
    protected ?Site $entity = null;

    public function getEntity(): Site
    {
        return $this->entity;
    }
}
