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

use Zentlix\MainBundle\Application\Command\UpdateCommandInterface;
use Zentlix\MainBundle\Domain\Locale\Entity\Locale;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    public function __construct(Locale $locale)
    {
        $this->entity = $locale;
        $this->title = $locale->getTitle();
        $this->code = $locale->getCode();
        $this->sort = $locale->getSort();
    }
}