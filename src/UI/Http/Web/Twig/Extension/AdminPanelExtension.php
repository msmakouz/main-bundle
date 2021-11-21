<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension;

use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\VisualEditor\Service\VisualEditor;
use Zentlix\UserBundle\Domain\User\Entity\User;

final class AdminPanelExtension extends AbstractExtension
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
            new TwigFunction(
                'admin_panel',
                [$this, 'getAdminPanel'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    public function getAdminPanel(Environment $twig): ?string
    {
        /** @var User $user */
        $user = $this->security->getUser();

        if (\is_null($user) || !$user->isAdminRole()) {
            return null;
        }

        return $twig->render(
            '@MainBundle/widgets/admin_panel.html.twig',
            ['isEnabledEditor' => $this->editor->isEnabled()]
        );
    }
}
