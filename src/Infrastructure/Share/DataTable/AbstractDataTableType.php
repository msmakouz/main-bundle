<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Infrastructure\Share\DataTable;

use Doctrine\ORM\EntityManagerInterface;
use Omines\DataTablesBundle\DataTableTypeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

abstract class AbstractDataTableType implements DataTableTypeInterface {

    protected EntityManagerInterface $entityManager;
    protected Security $security;
    protected UrlGeneratorInterface $router;
    protected TranslatorInterface $translator;
    protected ContainerInterface $container;
    protected CsrfTokenManagerInterface $tokenManager;
    protected EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $entityManager,
                                Security $security,
                                UrlGeneratorInterface $router,
                                TranslatorInterface $translator,
                                ContainerInterface $container,
                                CsrfTokenManagerInterface $tokenManager,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->router = $router;
        $this->translator = $translator;
        $this->container = $container;
        $this->tokenManager = $tokenManager;
        $this->eventDispatcher = $eventDispatcher;
    }
}