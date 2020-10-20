<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Widget;

use Twig\Environment;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\UserBundle\Domain\User\Entity\User;
use Zentlix\MainBundle\Domain\VisualEditor\Service\VisualEditor;
use function is_null;

class AdminPanel extends AbstractExtension
{
    private Security $security;
    private VisualEditor $editor;

    public function __construct(Security $security, VisualEditor $editor)
    {
        $this->security = $security;
        $this->editor = $editor;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('admin_panel_widget', [$this, 'getAdminPanel'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function getAdminPanel(Environment $twig)
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if(is_null($user) || !$user->isAdminRole()) {
            return null;
        }

        return $twig->render('@MainBundle/widgets/admin_panel.html.twig', ['isEnabledEditor' => $this->editor->isEnabled()]);
    }
}