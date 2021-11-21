<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Template;

use Zentlix\MainBundle\Domain\Template\Entity\Template;
use Zentlix\MainBundle\Infrastructure\Share\Bus\UpdateCommandInterface;

class UpdateCommand extends Command implements UpdateCommandInterface
{
    public function __construct(Template $template)
    {
        $this->entity = $template;
        $this->title = $template->getTitle();
        $this->folder = $template->getFolder();
        $this->sort = $template->getSort();
    }
}
