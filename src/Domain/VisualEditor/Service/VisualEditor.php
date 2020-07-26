<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Domain\VisualEditor\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class VisualEditor
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function isEnabled(): bool
    {
        return $this->session->get('visual_editor', false);
    }

    public function enable(): void
    {
        $this->session->set('visual_editor', true);
    }

    public function disable(): void
    {
        $this->session->set('visual_editor', false);
    }
}