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

use Zentlix\MainBundle\Application\Command\UpdateCommandInterface;
use Zentlix\MainBundle\Domain\Site\Entity\Site;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    public function __construct(Site $site)
    {
        $this->entity = $site;
        $this->title = $site->getTitle();
        $this->url = $site->getUrl();
        $this->locale = $site->getLocale()->getId();
        $this->template = $site->getTemplate()->getId();
        $this->sort = $site->getSort();
        $this->setMeta($site->getMetaTitle(), $site->getMetaDescription(), $site->getMetaKeywords());
    }
}