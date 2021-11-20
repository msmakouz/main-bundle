<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\VisualEditor\Service;

use Symfony\Component\HttpFoundation\RequestStack;

class VisualEditor
{
    public function __construct(
        private RequestStack $requestStack
    ) {
    }

    public function isEnabled(): bool
    {
        return $this->requestStack->getSession()->get('visual_editor', false);
    }

    public function enable(): void
    {
        $this->requestStack->getSession()->set('visual_editor', true);
    }

    public function disable(): void
    {
        $this->requestStack->getSession()->set('visual_editor', false);
    }
}