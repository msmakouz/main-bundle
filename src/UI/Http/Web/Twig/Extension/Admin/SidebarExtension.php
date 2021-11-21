<?php

declare(strict_types=1);

namespace Zentlix\MainBundle\UI\Http\Web\Twig\Extension\Admin;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Zentlix\MainBundle\Domain\AdminSidebar\Event\AfterBuild;
use Zentlix\MainBundle\Domain\AdminSidebar\Event\BeforeBuild;
use Zentlix\MainBundle\Domain\AdminSidebar\Service\SidebarInterface;

final class SidebarExtension extends AbstractExtension
{
    private SidebarInterface $sidebar;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(SidebarInterface $sidebar, EventDispatcherInterface $eventDispatcher)
    {
        $this->sidebar = $sidebar;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'admin_sidebar',
                [$this, 'buildSidebar'],
                ['needs_environment' => true, 'is_safe' => ['html']]
            ),
        ];
    }

    public function buildSidebar(Environment $twig): string
    {
        $this->eventDispatcher->dispatch(new BeforeBuild($this->sidebar));
        $this->eventDispatcher->dispatch(new AfterBuild($this->sidebar));

        return $twig->render('@MainBundle/admin/widgets/sidebar.html.twig', ['items' => $this->sidebar->build()]);
    }
}
