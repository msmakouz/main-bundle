<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Site;

use Zentlix\MainBundle\Domain\Site\Entity\Site;
use Zentlix\MainBundle\Infrastructure\Share\Bus\UpdateCommandInterface;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    public function __construct(Site $site)
    {
        $this->entity = $site;
        $this->title = $site->getTitle();
        $this->url = $site->getUrl();
        $this->locale = $site->getLocale()->getId()->toRfc4122();
        $this->template = $site->getTemplate()->getId()->toRfc4122();
        $this->sort = $site->getSort();
        $this->setMeta($site->getMetaTitle(), $site->getMetaDescription(), $site->getMetaKeywords());
    }
}
