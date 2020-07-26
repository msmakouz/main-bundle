<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Query\State;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Zentlix\MainBundle\Application\Query\QueryHandlerInterface;
use Zentlix\MainBundle\Domain\AdminSidebar\Event\BeforeBuild;
use Zentlix\MainBundle\Domain\AdminSidebar\Event\AfterBuild;
use Zentlix\MainBundle\Domain\AdminSidebar\Service\SidebarInterface;
use Zentlix\MainBundle\Domain\Locale\Repository\LocaleRepository;
use Zentlix\UserBundle\Domain\Admin\Repository\NotificationRepository;
use Zentlix\UserBundle\Domain\Admin\Service\AdminSettings;

class BuildQueryHandler implements QueryHandlerInterface
{
    private EventDispatcherInterface $eventDispatcher;
    private SidebarInterface $sidebar;
    private LocaleRepository $localeRepository;
    private Security $security;
    private UrlGeneratorInterface $router;
    private NotificationRepository $notificationRepository;
    private AdminSettings $adminSettings;

    public function __construct(EventDispatcherInterface $eventDispatcher,
                                Security $security,
                                UrlGeneratorInterface $router,
                                LocaleRepository $localeRepository,
                                NotificationRepository $notificationRepository,
                                SidebarInterface $sidebar,
                                AdminSettings $adminSettings)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->sidebar = $sidebar;
        $this->localeRepository = $localeRepository;
        $this->notificationRepository = $notificationRepository;
        $this->security = $security;
        $this->router = $router;
        $this->adminSettings = $adminSettings;
    }

    public function __invoke(BuildQuery $query): array
    {
        $this->eventDispatcher->dispatch(new BeforeBuild($this->sidebar));
        $this->eventDispatcher->dispatch(new AfterBuild($this->sidebar));

        return [
            'sidebar'       => $this->sidebar->build(),
            'locales'       => $this->localeRepository->findAll(),
            'currentLocale' => $this->adminSettings->getLocale()->getId(),
            'user'          => $this->security->getUser(),
            'notifications' => $this->notificationRepository->findLastByUserId($this->security->getUser()->getId()),
            'logoutUrl'     => $this->router->generate('app_logout')
        ];
    }
}