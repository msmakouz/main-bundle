<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Route\Entity\Route;
use Zentlix\MainBundle\Domain\Route\Event\BeforeUpdate;
use Zentlix\MainBundle\Domain\Route\Event\AfterUpdate;
use Zentlix\MainBundle\Domain\Route\Repository\RouteRepository;
use Zentlix\MainBundle\Domain\Route\Specification\UniqueUrlsInArraySpecification;
use Zentlix\MainBundle\Domain\Route\Specification\IsUrlValidSpecification;
use Zentlix\MainBundle\Domain\Cache\Service\Cache;

class UpdateHandler implements CommandHandlerInterface
{
    private UniqueUrlsInArraySpecification $uniqueUrlsInArraySpecification;
    private IsUrlValidSpecification $isUrlValidSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private RouteRepository $routeRepository;
    private Cache $cache;

    public function __construct(UniqueUrlsInArraySpecification $uniqueUrlsInArraySpecification,
                                IsUrlValidSpecification $isUrlValidSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                RouteRepository $routeRepository,
                                Cache $cache)
    {
        $this->uniqueUrlsInArraySpecification = $uniqueUrlsInArraySpecification;
        $this->isUrlValidSpecification = $isUrlValidSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->routeRepository = $routeRepository;
        $this->cache = $cache;
    }

    public function __invoke(UpdateCommand $command): void
    {
        $routes = $command->routes;

        $this->uniqueUrlsInArraySpecification->isUnique($routes);

        /** @var Route $route */
        foreach ($routes as $key => $route) {
            $this->isUrlValidSpecification->isValid($route->getUrl());
        }

        $this->eventDispatcher->dispatch(new BeforeUpdate($command));

        $this->entityManager->flush();

        $this->cache->clearRoutes();

        $this->eventDispatcher->dispatch(new AfterUpdate($route, $command));
    }
}