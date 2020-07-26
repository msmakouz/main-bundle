<?php

/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Zentlix to newer
 * versions in the future. If you wish to customize Zentlix for your
 * needs please refer to https://docs.zentlix.io for more information.
 */

declare(strict_types=1);

namespace Zentlix\MainBundle\Application\Command\Bundle;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zentlix\MainBundle\Application\Command\CommandHandlerInterface;
use Zentlix\MainBundle\Domain\Bundle\Specification\IsNotSystemSpecification;
use Zentlix\MainBundle\Domain\Bundle\Event\BeforeDeactivate;
use Zentlix\MainBundle\Domain\Bundle\Event\AfterDeactivate;
use Zentlix\MainBundle\Domain\Bundle\Service\Bundles;
use Zentlix\MainBundle\Domain\Bundle\Repository\BundleRepository;

class DeactivateHandler implements CommandHandlerInterface
{
    private IsNotSystemSpecification $isNotSystemSpecification;
    private EntityManagerInterface $entityManager;
    private EventDispatcherInterface $eventDispatcher;
    private BundleRepository $bundleRepository;
    private Bundles $bundles;

    public function __construct(IsNotSystemSpecification $isNotSystemSpecification,
                                EntityManagerInterface $entityManager,
                                EventDispatcherInterface $eventDispatcher,
                                BundleRepository $moduleRepository,
                                Bundles $bundles)
    {
        $this->isNotSystemSpecification = $isNotSystemSpecification;
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->bundleRepository = $moduleRepository;
        $this->bundles = $bundles;
    }

    public function __invoke(DeactivateCommand $command): void
    {
        $this->isNotSystemSpecification->isNotSystem((int) $command->id);

        $bundle = $this->bundleRepository->get((int) $command->id);
        $class = $bundle->getClass();

        $bundleObject = $this->bundles->getByClass($class);

        $this->eventDispatcher->dispatch(new BeforeDeactivate($bundle));

        $bundleObject->uninstall();

        $this->entityManager->remove($bundle);
        $this->entityManager->flush();

        $this->eventDispatcher->dispatch(new AfterDeactivate($class));
    }
}