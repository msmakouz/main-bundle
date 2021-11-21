<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Locale;

use Zentlix\MainBundle\Domain\Locale\Entity\Locale;
use Zentlix\MainBundle\Infrastructure\Share\Bus\UpdateCommandInterface;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    public function __construct(Locale $locale)
    {
        $this->entity = $locale;
        $this->title = $locale->getTitle();
        $this->code = $locale->getCode();
        $this->sort = $locale->getSort();
        $this->icon = $locale->getIcon();
    }
}
